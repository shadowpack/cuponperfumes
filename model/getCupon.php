<?php
session_start();
require('fpdf/fpdf.php');
require('db_core.php');
include('Barcode.php');
class PDF extends FPDF
{
    function EAN13($x, $y, $barcode, $h=16, $w=.35)
    {
        $this->Barcode($x,$y,$barcode,$h,$w,13);
    }

    function UPC_A($x, $y, $barcode, $h=16, $w=.35)
    {
        $this->Barcode($x,$y,$barcode,$h,$w,12);
    }

    function GetCheckDigit($barcode)
    {
        //Compute the check digit
        $sum=0;
        for($i=1;$i<=11;$i+=2)
            $sum+=3*$barcode[$i];
        for($i=0;$i<=10;$i+=2)
            $sum+=$barcode[$i];
        $r=$sum%10;
        if($r>0)
            $r=10-$r;
        return $r;
    }

    function TestCheckDigit($barcode)
    {
        //Test validity of check digit
        $sum=0;
        for($i=1;$i<=11;$i+=2)
            $sum+=3*$barcode[$i];
        for($i=0;$i<=10;$i+=2)
            $sum+=$barcode[$i];
        return ($sum+$barcode[12])%10==0;
    }

    function Barcode($x, $y, $barcode, $h, $w, $len)
    {
        //Padding
        $barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
        if($len==12)
            $barcode='0'.$barcode;
        //Add or control the check digit
        if(strlen($barcode)==12)
            $barcode.=$this->GetCheckDigit($barcode);
        elseif(!$this->TestCheckDigit($barcode))
            $this->Error('Incorrect check digit');
        //Convert digits to bars
        $codes=array(
            'A'=>array(
                '0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
                '5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
            'B'=>array(
                '0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
                '5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
            'C'=>array(
                '0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
                '5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
            );
        $parities=array(
            '0'=>array('A','A','A','A','A','A'),
            '1'=>array('A','A','B','A','B','B'),
            '2'=>array('A','A','B','B','A','B'),
            '3'=>array('A','A','B','B','B','A'),
            '4'=>array('A','B','A','A','B','B'),
            '5'=>array('A','B','B','A','A','B'),
            '6'=>array('A','B','B','B','A','A'),
            '7'=>array('A','B','A','B','A','B'),
            '8'=>array('A','B','A','B','B','A'),
            '9'=>array('A','B','B','A','B','A')
            );
        $code='101';
        $p=$parities[$barcode[0]];
        for($i=1;$i<=6;$i++)
            $code.=$codes[$p[$i-1]][$barcode[$i]];
        $code.='01010';
        for($i=7;$i<=12;$i++)
            $code.=$codes['C'][$barcode[$i]];
        $code.='101';
        //Draw bars
        for($i=0;$i<strlen($code);$i++)
        {
            if($code[$i]=='1')
                $this->Rect($x+$i*$w,$y,$w,$h,'F');
        }
        //Print text uder barcode
        $this->SetFont('Arial','',12);
        $this->Text($x,$y+$h+11/$this->k,substr($barcode,-$len));
    }
    function Header()
    {
        $db = new db_core();
        $user = $db->reg_one("SELECT id_user FROM session_log WHERE token='".$_SESSION['token']."'");
        $this->consulta = $db->reg_one("SELECT * FROM productos as p 
            LEFT JOIN transacciones ON transacciones.id_producto=p.id_item 
            INNER JOIN cupones ON cupones.id_transaccion = transacciones.id_transaccion
            WHERE transacciones.id_user='".$user[0]."' AND transacciones.statusPay='1' AND transacciones.id_transaccion='".$_GET['id']."';");
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // ponemos el logo
        $this->Image('../images/plataform/logocp.png',10,6,30);
        // Line break
        $this->SetDrawColor(210,211,205);
        $this->SetLineWidth(0.01);
        // Title
        $this->Cell(190,30,"","B",0,'L');
        $this->SetFont('Arial','',11);
        $this->SetXY(165, 5);
        $this->Cell(30,10,"Valido hasta","",0,'C');
        $this->SetXY(165, 12);
        $this->SetFont('Arial','B',12);
        $this->Cell(30,10,$this->consulta['expiracion'],"",0,'C');
        $this->SetXY(165, 19);
        $this->SetFont('Arial','',11);
        $this->Cell(30,10,"Codigo del Cupon","",0,'C');
        $this->SetXY(165, 26);
        $this->SetFont('Arial','B',12);
        $this->Cell(30,10,$this->consulta['codigo_cupon'],"",0,'C');
         // Line break
        $this->Ln();
        $this->SetFont('Arial','',10);
        // Output justified text
        $this->SetXY(48, 12);
        $this->MultiCell(100,5,$this->consulta['descripcion_small']);
        // Line break
        $this->Ln();
    }
    function bajada(){
        $this->SetFont('Arial','B',10);
        $this->Text(10, 47, "Detalle de la Oferta : ");
        $this->Text(10, 56, $this->consulta['nombre']);
        $this->Text(10, 65, "Caracteristicas : ");
        $this->SetXY(10, 71);
        $this->SetFont('Arial','',8);
        $this->MultiCell(190,5,$this->consulta['descripcion']);
        $this->SetDrawColor(210,211,205);
        $this->Line(10, 130, 200, 130);
    }
    function body(){
        $this->SetFont('Arial','B',8);
        $this->Text(10, 140, "Reglas Claras : ");
        $this->SetXY(10, 140);
        $this->SetFont('Arial','',10);
        $this->MultiCell(190,5,$this->consulta['condiciones']);
       
    }
    function prefooter(){
        $this->Text(10, 230, "_________________________________________________________________________________________________");
        $this->SetFont('Arial','B',10);
        $this->Text(10, 240, "Donde Canjear : ");
        $this->Text(10, 250, "Luis Thayer Ojeda 183, Oficina 304, Providencia; Lunes a viernes de 10:30 hasta 18:30 hrs");
        $this->SetFont('Arial','B',16);
        $this->Text(10, 265, "Precio: $".$this->consulta['precio_descuento']);
        $this->EAN13(85,260,$this->consulta['codigo_cupon']);
  
    }
    function Footer()
    {

    }


    function PrintChapter()
    {
        $this->AddPage();
        $this->bajada();
        $this->body();
        $this->prefooter();
    }
}

$pdf = new PDF();
$pdf->SetTitle("Cupon de Descuento");
$pdf->SetAuthor('Cuponperfume');
$pdf->PrintChapter();
$pdf->Output();
?>