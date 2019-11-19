<?php
	class Export extends CI_Controller {

	private $limit=10;

	function __construct()
	{
	parent::__construct();
	#load library dan helper yang dibutuhkan
	$this->load->library(array('table','form_validation'));
	$this->load->helper(array('form','url'));
	$this->load->library('excel');
	$this->load->model(array('pertanyaan_model','jawaban_model','data_model','data2_model','about_model'));
	error_reporting(E_ALL & ~E_NOTICE);
	}
	
	function index()
	{
		echo "tes";
	}
	function harian($filetype='',$from='',$to='')
	{
	if (empty($filetype)) $filetype='xlsx';
	if (empty($from)) $from=date('Y-m-d');
	if (empty($to)) $to=date('Y-m-d');
	//echo $filetype.$from.$to;
	$config['base_url']= site_url('export/index/');
	$config['uri_segment']=4;
	
	$survey = $this->data_model->get_by_tanggal($from,$to)->result();
	$this->excel->setActiveSheetIndex(0);
	$this->excel->getActiveSheet()->setTitle('Laporan Harian');
	$worksheet = $this->excel->getActiveSheet();
	$worksheet->SetCellValue('A1', 'Laporan Harian Periode '.date('d-M-y',strtotime($from)).' s/d '.date('d-M-y',strtotime($to)));
	$worksheet->mergeCells('A1:R1');


	$this->excel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$worksheet->SetCellValue('A3', 'Tanggal');
	$worksheet->SetCellValue('B3', 'Jenis Kelamin');
	$worksheet->SetCellValue('C3', 'Umur');
	$worksheet->SetCellValue('D3', 'Pendidikan');
	$worksheet->SetCellValue('E3', 'Pekerjaan');
	$worksheet->SetCellValue('F3', '1');
	$worksheet->SetCellValue('G3', '2');
	$worksheet->SetCellValue('H3', '3');
	$worksheet->SetCellValue('I3', '4');
	$worksheet->SetCellValue('J3', '5');
	$worksheet->SetCellValue('K3', '6');
	$worksheet->SetCellValue('L3', '7');
	$worksheet->SetCellValue('M3', '8');
	$worksheet->SetCellValue('N3', '9');
	$worksheet->SetCellValue('O3', 'Rata');
	$worksheet->SetCellValue('P3', 'Nilai Interval Konversi');
	$worksheet->SetCellValue('Q3', 'P/TP');
	$worksheet->SetCellValue('R3', 'Saran');


	//judul
	$this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setSize(20);
	$this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);

	//tabel header
	$this->excel->getActiveSheet()->getStyle('A3:R3')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A3:R3')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A3:R3')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A3:R3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');


	$no = 1;
	$i=4;

	foreach ($survey as $value){
		$persen=$this->data_model->get_by_average($value->id)->row()->avg/$this->jawaban_model->get_by_max()->row()->max*100;
		$kesimpulan=$this->data_model->get_kesimpulan($persen)->row()->value;
		
		$worksheet->setCellValue('A'.$i,date('d-M-y',strtotime($value->datetime)));
		$worksheet->SetCellValue('B'.$i,$this->data_model->get_by_detail_id($value->id,1)->row()->jawaban); 
		$worksheet->SetCellValue('C'.$i,$this->data_model->get_by_detail_id($value->id,12)->row()->jawaban); 
		$worksheet->SetCellValue('D'.$i,$this->data_model->get_by_detail_id($value->id,13)->row()->jawaban); 
		$worksheet->SetCellValue('E'.$i,$this->data_model->get_by_detail_id($value->id,14)->row()->jawaban);
		$worksheet->SetCellValue('F'.$i,$this->data_model->get_by_detail_id($value->id,2)->row()->bobot); 
		$worksheet->SetCellValue('G'.$i,$this->data_model->get_by_detail_id($value->id,3)->row()->bobot); 
		$worksheet->SetCellValue('H'.$i,$this->data_model->get_by_detail_id($value->id,4)->row()->bobot);
		$worksheet->SetCellValue('I'.$i,$this->data_model->get_by_detail_id($value->id,5)->row()->bobot);
		$worksheet->SetCellValue('J'.$i,$this->data_model->get_by_detail_id($value->id,6)->row()->bobot);
		$worksheet->SetCellValue('K'.$i,$this->data_model->get_by_detail_id($value->id,7)->row()->bobot);
		$worksheet->SetCellValue('L'.$i,$this->data_model->get_by_detail_id($value->id,8)->row()->bobot);
		$worksheet->SetCellValue('M'.$i,$this->data_model->get_by_detail_id($value->id,9)->row()->bobot);
		$worksheet->SetCellValue('N'.$i,$this->data_model->get_by_detail_id($value->id,10)->row()->bobot);
		$worksheet->SetCellValue('O'.$i,$this->data_model->get_by_average($value->id)->row()->avg);
		$worksheet->SetCellValue('P'.$i,$persen);
		$worksheet->SetCellValue('Q'.$i,$kesimpulan);
		$worksheet->SetCellValue('R'.$i,getjawaban($this->data_model->get_by_detail_id($value->id,11)->row()));
		$i++;
		$no++;
	}


	$worksheet->SetCellValue('B'.$i,'Rata');
	$worksheet->SetCellValue('F'.$i,'=AVERAGE(F4:F'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('G'.$i,'=AVERAGE(G4:G'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('H'.$i,'=AVERAGE(H4:H'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('I'.$i,'=AVERAGE(I4:I'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('J'.$i,'=AVERAGE(J4:J'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('K'.$i,'=AVERAGE(K4:K'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('L'.$i,'=AVERAGE(L4:L'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('M'.$i,'=AVERAGE(M4:M'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('N'.$i,'=AVERAGE(N4:N'.($i-1).')'); // Rata2

	$i++;
	$worksheet->SetCellValue('N'.$i,'Rata');
	
	$worksheet->SetCellValue('O'.$i,'=AVERAGE(F'.($i-1).':N'.($i-1).')'); // Rata2
	//tabel footer
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':R'.$i)->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':R'.$i)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':R'.$i)->getFont()->setBold(true);

	//isi tabel
	$this->excel->getActiveSheet()->getStyle('A4:' . $this->excel->getActiveSheet()->getHighestColumn() . $this->excel->getActiveSheet()->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$this->excel->getActiveSheet()->getStyle('A3:R3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$this->excel->getActiveSheet()->getStyle('A3:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	
	
	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);



		
	if($filetype=='xlsx'){
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	if($filetype=='pdf'){
	$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
    $rendererLibrary = 'dompdf';
    $rendererLibraryPath = APPPATH.'/third_party/phpexcel/PHPExcel/Writer/'. $rendererLibrary;
    	if (!PHPExcel_Settings::setPdfRenderer(
        $rendererName,
        $rendererLibraryPath
    	)) {
        die(
        'Please set the $rendererName and $rendererLibraryPath values' .
        PHP_EOL .
        ' as appropriate for your directory structure'
        );
    	}
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
	header('Content-Type: application/pdf');
	}
	header('Content-Disposition: attachment;filename="Laporan Harian.'.$filetype.'"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	$this->excel->disconnectWorksheets();
	
	}
	
	function bulanan($filetype='',$date)
	{
	if (empty($filetype)) $filetype='xlsx';
	if (empty($date)) $date=date('Y-m-01');
	//echo $filetype.$from.$to;
	$config['base_url']= site_url('export/index/');
	$config['uri_segment']=4;
	$date = date('Y-m-01',strtotime($date));
	$count=$this->data_model->get_by_kesimpulan_count($date,2)->row()->total;
	
	$this->excel->setActiveSheetIndex(0);
	$this->excel->getActiveSheet()->setTitle('Laporan Bulanan');
	$worksheet = $this->excel->getActiveSheet();
	$worksheet->SetCellValue('A1', 'Laporan Bulanan '.date('M-Y',strtotime($date)));
	$worksheet->mergeCells('A1:N1');
	$worksheet->mergeCells('A2:D2');
	$worksheet->mergeCells('F2:I2');
	$worksheet->mergeCells('K2:N2');
	$worksheet->mergeCells('A10:D10');
	$worksheet->mergeCells('F10:I10');
	$worksheet->mergeCells('K10:N10');
	$worksheet->mergeCells('A18:D18');
	$worksheet->mergeCells('F18:I18');
	$worksheet->mergeCells('K18:N18');
	$worksheet->SetCellValue('A2', $this->pertanyaan_model->get_by_id(2)->row()->ruang_lingkup);
	$worksheet->SetCellValue('F2', $this->pertanyaan_model->get_by_id(3)->row()->ruang_lingkup);
	$worksheet->SetCellValue('K2', $this->pertanyaan_model->get_by_id(4)->row()->ruang_lingkup);
	$worksheet->SetCellValue('A10', $this->pertanyaan_model->get_by_id(5)->row()->ruang_lingkup);
	$worksheet->SetCellValue('F10', $this->pertanyaan_model->get_by_id(6)->row()->ruang_lingkup);
	$worksheet->SetCellValue('K10', $this->pertanyaan_model->get_by_id(7)->row()->ruang_lingkup);
	$worksheet->SetCellValue('A18', $this->pertanyaan_model->get_by_id(8)->row()->ruang_lingkup);
	$worksheet->SetCellValue('F18', $this->pertanyaan_model->get_by_id(9)->row()->ruang_lingkup);
	$worksheet->SetCellValue('K18', $this->pertanyaan_model->get_by_id(10)->row()->ruang_lingkup);

	$this->excel->getActiveSheet()->getStyle('A2:D7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('F2:I7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('K2:N7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('A10:D15')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('F10:I15')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('K10:N15')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('A18:D23')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('F18:I23')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('K18:N23')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('C8')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('H8')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M8')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('C16')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('H16')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M16')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('C24')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('H24')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M24')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A2:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A10:N11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A18:N19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('A10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('A18')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('F10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('F18')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('K10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('K18')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');

	
	$idpertanyaan=2;
	$worksheet->SetCellValue('A3', 'No');
	$worksheet->SetCellValue('B3', 'Jawaban');
	$worksheet->SetCellValue('C3', 'Frekuensi');
	$worksheet->SetCellValue('D3', '%');
	$worksheet->SetCellValue('A4', '1');
	$worksheet->SetCellValue('B4', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('C4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('D4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,$idpertanyaan)->row()->total/$count*100);
	$worksheet->SetCellValue('A5', '2');
	$worksheet->SetCellValue('B5', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('C5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('D5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,$idpertanyaan)->row()->total/$count*100);
	$worksheet->SetCellValue('A6', '3');
	$worksheet->SetCellValue('B6', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('C6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('D6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,$idpertanyaan)->row()->total/$count*100);
	$worksheet->SetCellValue('A7', '4');
	$worksheet->SetCellValue('B7', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('C7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('D7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,$idpertanyaan)->row()->total/$count*100);
	$worksheet->SetCellValue('C8','=SUM(C4:C7)'); 
	
	$idpertanyaan=3;
	$worksheet->SetCellValue('F3', 'No');
	$worksheet->SetCellValue('G3', 'Jawaban');
	$worksheet->SetCellValue('H3', 'Frekuensi');
	$worksheet->SetCellValue('I3', '%');
	$worksheet->SetCellValue('F4', '1');
	$worksheet->SetCellValue('G4', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('H4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,3)->row()->total);
	$worksheet->SetCellValue('I4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,3)->row()->total/$count*100);
	$worksheet->SetCellValue('F5', '2');
	$worksheet->SetCellValue('G5', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('H5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,3)->row()->total);
	$worksheet->SetCellValue('I5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,3)->row()->total/$count*100);
	$worksheet->SetCellValue('F6', '3');
	$worksheet->SetCellValue('G6', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('H6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,3)->row()->total);
	$worksheet->SetCellValue('I6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,3)->row()->total/$count*100);
	$worksheet->SetCellValue('F7', '4');
	$worksheet->SetCellValue('G7', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('H7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,3)->row()->total);
	$worksheet->SetCellValue('I7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,3)->row()->total/$count*100);
	$worksheet->SetCellValue('H8','=SUM(H4:H7)'); 
	
	$idpertanyaan=4;
	$worksheet->SetCellValue('K3', 'No');
	$worksheet->SetCellValue('L3', 'Jawaban');
	$worksheet->SetCellValue('M3', 'Frekuensi');
	$worksheet->SetCellValue('N3', '%');
	$worksheet->SetCellValue('K4', '1');
	$worksheet->SetCellValue('L4', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('M4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,4)->row()->total);
	$worksheet->SetCellValue('N4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,4)->row()->total/$count*100);
	$worksheet->SetCellValue('K5', '2');
	$worksheet->SetCellValue('L5', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('M5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,4)->row()->total);
	$worksheet->SetCellValue('N5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,4)->row()->total/$count*100);
	$worksheet->SetCellValue('K6', '3');
	$worksheet->SetCellValue('L6', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('M6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,4)->row()->total);
	$worksheet->SetCellValue('N6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,4)->row()->total/$count*100);
	$worksheet->SetCellValue('K7', '4');
	$worksheet->SetCellValue('L7', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('M7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,4)->row()->total);
	$worksheet->SetCellValue('N7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,4)->row()->total/$count*100);
	$worksheet->SetCellValue('M8','=SUM(M4:M7)'); 
	
	$idpertanyaan=5;
	$worksheet->SetCellValue('A11', 'No');
	$worksheet->SetCellValue('B11', 'Jawaban');
	$worksheet->SetCellValue('C11', 'Frekuensi');
	$worksheet->SetCellValue('D11', '%');
	$worksheet->SetCellValue('A12', '1');
	$worksheet->SetCellValue('B12', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('C12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,5)->row()->total);
	$worksheet->SetCellValue('D12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,5)->row()->total/$count*100);
	$worksheet->SetCellValue('A13', '2');
	$worksheet->SetCellValue('B13', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('C13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,5)->row()->total);
	$worksheet->SetCellValue('D13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,5)->row()->total/$count*100);
	$worksheet->SetCellValue('A14', '3');
	$worksheet->SetCellValue('B14', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('C14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,5)->row()->total);
	$worksheet->SetCellValue('D14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,5)->row()->total/$count*100);
	$worksheet->SetCellValue('A15', '4');
	$worksheet->SetCellValue('B15', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('C15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,5)->row()->total);
	$worksheet->SetCellValue('D15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,5)->row()->total/$count*100);
	$worksheet->SetCellValue('C16','=SUM(C12:C15)'); 
	
	$idpertanyaan=6;
	$worksheet->SetCellValue('F11', 'No');
	$worksheet->SetCellValue('G11', 'Jawaban');
	$worksheet->SetCellValue('H11', 'Frekuensi');
	$worksheet->SetCellValue('I11', '%');
	$worksheet->SetCellValue('F12', '1');
	$worksheet->SetCellValue('G12', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('H12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,6)->row()->total);
	$worksheet->SetCellValue('I12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,6)->row()->total/$count*100);
	$worksheet->SetCellValue('F13', '2');
	$worksheet->SetCellValue('G13', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('H13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,6)->row()->total);
	$worksheet->SetCellValue('I13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,6)->row()->total/$count*100);
	$worksheet->SetCellValue('F14', '3');
	$worksheet->SetCellValue('G14', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('H14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,6)->row()->total);
	$worksheet->SetCellValue('I14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,6)->row()->total/$count*100);
	$worksheet->SetCellValue('F15', '4');
	$worksheet->SetCellValue('G15', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('H15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,6)->row()->total);
	$worksheet->SetCellValue('I15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,6)->row()->total/$count*100);
	$worksheet->SetCellValue('H16','=SUM(H12:H15)'); 
	
	$idpertanyaan=7;
	$worksheet->SetCellValue('K11', 'No');
	$worksheet->SetCellValue('L11', 'Jawaban');
	$worksheet->SetCellValue('M11', 'Frekuensi');
	$worksheet->SetCellValue('N11', '%');
	$worksheet->SetCellValue('K12', '1');
	$worksheet->SetCellValue('L12', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('M12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,7)->row()->total);
	$worksheet->SetCellValue('N12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,7)->row()->total/$count*100);
	$worksheet->SetCellValue('K13', '2');
	$worksheet->SetCellValue('L13', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('M13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,7)->row()->total);
	$worksheet->SetCellValue('N13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,7)->row()->total/$count*100);
	$worksheet->SetCellValue('K14', '3');
	$worksheet->SetCellValue('L14', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('M14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,7)->row()->total);
	$worksheet->SetCellValue('N14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,7)->row()->total/$count*100);
	$worksheet->SetCellValue('K15', '4');
	$worksheet->SetCellValue('L15', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('M15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,7)->row()->total);
	$worksheet->SetCellValue('N15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,7)->row()->total/$count*100);
	$worksheet->SetCellValue('M16','=SUM(M12:M15)'); 
	
	$idpertanyaan=8;
	$worksheet->SetCellValue('A19', 'No');
	$worksheet->SetCellValue('B19', 'Jawaban');
	$worksheet->SetCellValue('C19', 'Frekuensi');
	$worksheet->SetCellValue('D19', '%');
	$worksheet->SetCellValue('A20', '1');
	$worksheet->SetCellValue('B20', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('C20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,8)->row()->total);
	$worksheet->SetCellValue('D20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,8)->row()->total/$count*100);
	$worksheet->SetCellValue('A21', '2');
	$worksheet->SetCellValue('B21', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('C21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,8)->row()->total);
	$worksheet->SetCellValue('D21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,8)->row()->total/$count*100);
	$worksheet->SetCellValue('A22', '3');
	$worksheet->SetCellValue('B22', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('C22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,8)->row()->total);
	$worksheet->SetCellValue('D22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,8)->row()->total/$count*100);
	$worksheet->SetCellValue('A23', '4');
	$worksheet->SetCellValue('B23', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('C23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,8)->row()->total);
	$worksheet->SetCellValue('D23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,8)->row()->total/$count*100);
	$worksheet->SetCellValue('C24','=SUM(C20:C23)'); 
	
	$idpertanyaan=9;
	$worksheet->SetCellValue('F19', 'No');
	$worksheet->SetCellValue('G19', 'Jawaban');
	$worksheet->SetCellValue('H19', 'Frekuensi');
	$worksheet->SetCellValue('I19', '%');
	$worksheet->SetCellValue('F20', '1');
	$worksheet->SetCellValue('G20', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('H20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,9)->row()->total);
	$worksheet->SetCellValue('I20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,9)->row()->total/$count*100);
	$worksheet->SetCellValue('F21', '2');
	$worksheet->SetCellValue('G21', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('H21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,9)->row()->total);
	$worksheet->SetCellValue('I21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,9)->row()->total/$count*100);
	$worksheet->SetCellValue('F22', '3');
	$worksheet->SetCellValue('G22', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('H22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,9)->row()->total);
	$worksheet->SetCellValue('I22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,9)->row()->total/$count*100);
	$worksheet->SetCellValue('F23', '4');
	$worksheet->SetCellValue('G23', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('H23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,9)->row()->total);
	$worksheet->SetCellValue('I23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,9)->row()->total/$count*100);
	$worksheet->SetCellValue('H24','=SUM(H20:H23)'); 
	
	$idpertanyaan=10;
	$worksheet->SetCellValue('K19', 'No');
	$worksheet->SetCellValue('L19', 'Jawaban');
	$worksheet->SetCellValue('M19', 'Frekuensi');
	$worksheet->SetCellValue('N19', '%');
	$worksheet->SetCellValue('K20', '1');
	$worksheet->SetCellValue('L20', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('M20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,10)->row()->total);
	$worksheet->SetCellValue('N20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,10)->row()->total/$count*100);
	$worksheet->SetCellValue('K21', '2');
	$worksheet->SetCellValue('L21', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('M21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,10)->row()->total);
	$worksheet->SetCellValue('N21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,10)->row()->total/$count*100);
	$worksheet->SetCellValue('K22', '3');
	$worksheet->SetCellValue('L22', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('M22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,10)->row()->total);
	$worksheet->SetCellValue('N22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,10)->row()->total/$count*100);
	$worksheet->SetCellValue('K23', '4');
	$worksheet->SetCellValue('L23', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('M23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,10)->row()->total);
	$worksheet->SetCellValue('N23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,10)->row()->total/$count*100);
	$worksheet->SetCellValue('M24','=SUM(M20:M23)'); 

	//judul
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setSize(20);
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);

	//tabel header
	$this->excel->getActiveSheet()->getStyle('A2:N3')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A2:N3')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A2:N3')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A10:N11')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A10:N11')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A10:N11')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A18:N19')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A18:N19')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A18:N19')->getFont()->setBold(true);
	//$this->excel->getActiveSheet()->getStyle('A2:N3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('66A342');

/*
	$worksheet->SetCellValue('B'.$i,'Rata');
	$worksheet->SetCellValue('C'.$i,'=AVERAGE(C4:C'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('D'.$i,'=AVERAGE(D4:D'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('E'.$i,'=AVERAGE(E4:E'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('F'.$i,'=AVERAGE(F4:F'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('G'.$i,'=AVERAGE(G4:G'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('H'.$i,'=AVERAGE(H4:H'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('I'.$i,'=AVERAGE(I4:I'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('J'.$i,'=AVERAGE(J4:J'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('K'.$i,'=AVERAGE(K4:K'.($i-1).')'); // Rata2

	$i++;
	$worksheet->SetCellValue('J'.$i,'Rata');
	
	$worksheet->SetCellValue('K'.$i,'=AVERAGE(C'.($i-1).':K'.($i-1).')'); // Rata2
	//tabel footer
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':N'.$i)->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':N'.$i)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':N'.$i)->getFont()->setBold(true);

	//isi tabel
	$this->excel->getActiveSheet()->getStyle('A4:' . $this->excel->getActiveSheet()->getHighestColumn() . $this->excel->getActiveSheet()->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$this->excel->getActiveSheet()->getStyle('A3:N3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$this->excel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	*/
	
	$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);


		
	if($filetype=='xlsx'){
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	if($filetype=='pdf'){
	$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
    $rendererLibrary = 'dompdf';
    $rendererLibraryPath = APPPATH.'/third_party/phpexcel/PHPExcel/Writer/'. $rendererLibrary;
    	if (!PHPExcel_Settings::setPdfRenderer(
        $rendererName,
        $rendererLibraryPath
    	)) {
        die(
        'Please set the $rendererName and $rendererLibraryPath values' .
        PHP_EOL .
        ' as appropriate for your directory structure'
        );
    	}
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
	header('Content-Type: application/pdf');
	}
	header('Content-Disposition: attachment;filename="Laporan Bulanan.'.$filetype.'"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	$this->excel->disconnectWorksheets();
	
	}
	
	function bulanan2($filetype='',$date,$date2)
	{
	if (empty($filetype)) $filetype='xlsx';
	if (empty($date)) $date=date('Y-m-d');
	if (empty($date2)) $date2=date('Y-m-d');
	//echo $filetype.$from.$to;
	$config['base_url']= site_url('export/index/');
	$config['uri_segment']=4;
	$date = date('Y-m-d',strtotime($date));
	$date2 = date('Y-m-d',strtotime($date2));
	$count=$this->data2_model->get_by_kesimpulan_count($date,$date2,2)->row()->total;
	
	$this->excel->setActiveSheetIndex(0);
	$this->excel->getActiveSheet()->setTitle('Laporan Bulanan');
	$worksheet = $this->excel->getActiveSheet();
	$worksheet->SetCellValue('A1', 'Laporan Bulanan '.date('d-M-Y',strtotime($date)).' s/d '.date('d-M-Y',strtotime($date2)));
	$worksheet->mergeCells('A1:Q1');
	$worksheet->mergeCells('A2:E2');
	$worksheet->mergeCells('G2:K2');
	$worksheet->mergeCells('M2:Q2');
	$worksheet->mergeCells('A12:E12');
	$worksheet->mergeCells('G12:K12');
	$worksheet->mergeCells('M12:Q12');
	$worksheet->mergeCells('A22:E22');
	$worksheet->mergeCells('G22:K22');
	$worksheet->mergeCells('M22:Q22');
	$worksheet->SetCellValue('A2', $this->pertanyaan_model->get_by_id(2)->row()->ruang_lingkup);
	$worksheet->SetCellValue('G2', $this->pertanyaan_model->get_by_id(3)->row()->ruang_lingkup);
	$worksheet->SetCellValue('M2', $this->pertanyaan_model->get_by_id(4)->row()->ruang_lingkup);
	$worksheet->SetCellValue('A12', $this->pertanyaan_model->get_by_id(5)->row()->ruang_lingkup);
	$worksheet->SetCellValue('G12', $this->pertanyaan_model->get_by_id(6)->row()->ruang_lingkup);
	$worksheet->SetCellValue('M12', $this->pertanyaan_model->get_by_id(7)->row()->ruang_lingkup);
	$worksheet->SetCellValue('A22', $this->pertanyaan_model->get_by_id(8)->row()->ruang_lingkup);
	$worksheet->SetCellValue('G22', $this->pertanyaan_model->get_by_id(9)->row()->ruang_lingkup);
	$worksheet->SetCellValue('M22', $this->pertanyaan_model->get_by_id(10)->row()->ruang_lingkup);

	$this->excel->getActiveSheet()->getStyle('A2:E10')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('G2:K10')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M2:Q10')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('A12:E20')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('G12:K20')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M12:Q20')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('A22:E30')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('G22:K30')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M22:Q30')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	/*
	$this->excel->getActiveSheet()->getStyle('C8')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('H8')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M8')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('C16')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('H16')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M16')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('C24')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('H24')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M24')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	*/
	$this->excel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A2:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A12:Q13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A22:Q23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('A12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('A22')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('G12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('G22')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('M2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('M12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('M22')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');

	
	$idpertanyaan=2;
	$worksheet->SetCellValue('A3', 'No');
	$worksheet->SetCellValue('B3', 'Jawaban');
	$worksheet->SetCellValue('C3', 'Nilai Persepsi');
	$worksheet->SetCellValue('D3', 'Frekuensi');
	$worksheet->SetCellValue('E3', 'Nilai Unsur');
	$worksheet->SetCellValue('A4', '1');
	$worksheet->SetCellValue('B4', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('C4', 4);
	$worksheet->SetCellValue('D4', $this->data2_model->get_by_kesimpulan_freq('SB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E4', '=C4*D4');
	$worksheet->SetCellValue('A5', '2');
	$worksheet->SetCellValue('B5', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('C5', 3);
	$worksheet->SetCellValue('D5', $this->data2_model->get_by_kesimpulan_freq('B',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E5', '=C5*D5');
	$worksheet->SetCellValue('A6', '3');
	$worksheet->SetCellValue('B6', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('C6', 2);
	$worksheet->SetCellValue('D6', $this->data2_model->get_by_kesimpulan_freq('KB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E6', '=C6*D6');
	$worksheet->SetCellValue('A7', '4');
	$worksheet->SetCellValue('B7', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('C7', 1);
	$worksheet->SetCellValue('D7', $this->data2_model->get_by_kesimpulan_freq('TB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E7', '=C7*D7');
	$worksheet->SetCellValue('D8','=SUM(D4:D7)'); 
	$worksheet->SetCellValue('E8','=SUM(E4:E7)');
	$worksheet->mergeCells('D9:E9');
	$worksheet->mergeCells('D10:E10');
	$worksheet->SetCellValue('D9','=E8/D8');
	$worksheet->SetCellValue('D10','=D9*0.11');
	$worksheet->SetCellValue('A8', 'Jumlah');
	$worksheet->SetCellValue('A9', 'Nilai Rata Rata');
	$worksheet->SetCellValue('A10', 'Nilai Rata Rata Tertimbang');
	$worksheet->mergeCells('A8:C8');
	$worksheet->mergeCells('A9:C9');
	$worksheet->mergeCells('A10:C10');
	
	$idpertanyaan=3;
	$worksheet->SetCellValue('G3', 'No');
	$worksheet->SetCellValue('H3', 'Jawaban');
	$worksheet->SetCellValue('I3', 'Nilai Persepsi');
	$worksheet->SetCellValue('J3', 'Frekuensi');
	$worksheet->SetCellValue('K3', 'Nilai Unsur');
	$worksheet->SetCellValue('G4', '1');
	$worksheet->SetCellValue('H4', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('I4', 4);
	$worksheet->SetCellValue('J4', $this->data2_model->get_by_kesimpulan_freq('SB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K4', '=I4*J4');
	$worksheet->SetCellValue('G5', '2');
	$worksheet->SetCellValue('H5', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('I5', 3);
	$worksheet->SetCellValue('J5', $this->data2_model->get_by_kesimpulan_freq('B',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K5', '=I5*J5');
	$worksheet->SetCellValue('G6', '3');
	$worksheet->SetCellValue('H6', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('I6', 2);
	$worksheet->SetCellValue('J6', $this->data2_model->get_by_kesimpulan_freq('KB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K6', '=I6*J6');
	$worksheet->SetCellValue('G7', '4');
	$worksheet->SetCellValue('H7', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('I7', 1);
	$worksheet->SetCellValue('J7', $this->data2_model->get_by_kesimpulan_freq('TB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K7', '=I7*J7');
	$worksheet->SetCellValue('J8','=SUM(J4:J7)'); 
	$worksheet->SetCellValue('K8','=SUM(K4:K7)');
	$worksheet->mergeCells('J9:K9');
	$worksheet->mergeCells('J10:K10');
	$worksheet->SetCellValue('J9','=K8/J8');
	$worksheet->SetCellValue('J10','=J9*0.11');
	$worksheet->SetCellValue('G8', 'Jumlah');
	$worksheet->SetCellValue('G9', 'Nilai Rata Rata');
	$worksheet->SetCellValue('G10', 'Nilai Rata Rata Tertimbang');
	$worksheet->mergeCells('G8:I8');
	$worksheet->mergeCells('G9:I9');
	$worksheet->mergeCells('G10:I10');
	
	$idpertanyaan=4;
	$worksheet->SetCellValue('M3', 'No');
	$worksheet->SetCellValue('N3', 'Jawaban');
	$worksheet->SetCellValue('O3', 'Nilai Persepsi');
	$worksheet->SetCellValue('P3', 'Frekuensi');
	$worksheet->SetCellValue('Q3', 'Nilai Unsur');
	$worksheet->SetCellValue('M4', '1');
	$worksheet->SetCellValue('N4', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('O4', 4);
	$worksheet->SetCellValue('P4', $this->data2_model->get_by_kesimpulan_freq('SB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q4', '=O4*P4');
	$worksheet->SetCellValue('M5', '2');
	$worksheet->SetCellValue('N5', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('O5', 3);
	$worksheet->SetCellValue('P5', $this->data2_model->get_by_kesimpulan_freq('B',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q5', '=O5*P5');
	$worksheet->SetCellValue('M6', '3');
	$worksheet->SetCellValue('N6', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('O6', 2);
	$worksheet->SetCellValue('P6', $this->data2_model->get_by_kesimpulan_freq('KB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q6', '=O6*P6');
	$worksheet->SetCellValue('M7', '4');
	$worksheet->SetCellValue('N7', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('O7', 1);
	$worksheet->SetCellValue('P7', $this->data2_model->get_by_kesimpulan_freq('TB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q7', '=O7*P7');
	$worksheet->SetCellValue('P8','=SUM(P4:P7)'); 
	$worksheet->SetCellValue('Q8','=SUM(Q4:Q7)');
	$worksheet->mergeCells('P9:Q9');
	$worksheet->mergeCells('P10:Q10');
	$worksheet->SetCellValue('P9','=Q8/P8');
	$worksheet->SetCellValue('P10','=P9*0.11');
	$worksheet->SetCellValue('M8', 'Jumlah');
	$worksheet->SetCellValue('M9', 'Nilai Rata Rata');
	$worksheet->SetCellValue('M10', 'Nilai Rata Rata Tertimbang');
	$worksheet->mergeCells('M8:O8');
	$worksheet->mergeCells('M9:O9');
	$worksheet->mergeCells('M10:O10');
	
	$idpertanyaan=5;
	$worksheet->SetCellValue('A13', 'No');
	$worksheet->SetCellValue('B13', 'Jawaban');
	$worksheet->SetCellValue('C13', 'Nilai Persepsi');
	$worksheet->SetCellValue('D13', 'Frekuensi');
	$worksheet->SetCellValue('E13', 'Nilai Unsur');
	$worksheet->SetCellValue('A14', '1');
	$worksheet->SetCellValue('B14', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('C14', 4);
	$worksheet->SetCellValue('D14', $this->data2_model->get_by_kesimpulan_freq('SB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E14', '=C14*D14');
	$worksheet->SetCellValue('A15', '2');
	$worksheet->SetCellValue('B15', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('C15', 3);
	$worksheet->SetCellValue('D15', $this->data2_model->get_by_kesimpulan_freq('B',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E15', '=C15*D15');
	$worksheet->SetCellValue('A16', '3');
	$worksheet->SetCellValue('B16', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('C16', 2);
	$worksheet->SetCellValue('D16', $this->data2_model->get_by_kesimpulan_freq('KB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E16', '=C16*D16');
	$worksheet->SetCellValue('A17', '4');
	$worksheet->SetCellValue('B17', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('C17', 1);
	$worksheet->SetCellValue('D17', $this->data2_model->get_by_kesimpulan_freq('TB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E17', '=C17*D17');
	$worksheet->SetCellValue('D18','=SUM(D14:D17)'); 
	$worksheet->SetCellValue('E18','=SUM(E14:E17)');
	$worksheet->mergeCells('D19:E19');
	$worksheet->mergeCells('D20:E20');
	$worksheet->SetCellValue('D19','=E18/D18');
	$worksheet->SetCellValue('D20','=D19*0.11');
	$worksheet->SetCellValue('A18', 'Jumlah');
	$worksheet->SetCellValue('A19', 'Nilai Rata Rata');
	$worksheet->SetCellValue('A20', 'Nilai Rata Rata Tertimbang');
	$worksheet->mergeCells('A18:C18');
	$worksheet->mergeCells('A19:C19');
	$worksheet->mergeCells('A20:C20');
	
	$idpertanyaan=6;
	$worksheet->SetCellValue('G13', 'No');
	$worksheet->SetCellValue('H13', 'Jawaban');
	$worksheet->SetCellValue('I13', 'Nilai Persepsi');
	$worksheet->SetCellValue('J13', 'Frekuensi');
	$worksheet->SetCellValue('K13', 'Nilai Unsur');
	$worksheet->SetCellValue('G14', '1');
	$worksheet->SetCellValue('H14', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('I14', 4);
	$worksheet->SetCellValue('J14', $this->data2_model->get_by_kesimpulan_freq('SB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K14', '=I14*J14');
	$worksheet->SetCellValue('G15', '2');
	$worksheet->SetCellValue('H15', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('I15', 3);
	$worksheet->SetCellValue('J15', $this->data2_model->get_by_kesimpulan_freq('B',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K15', '=I15*J15');
	$worksheet->SetCellValue('G16', '3');
	$worksheet->SetCellValue('H16', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('I16', 2);
	$worksheet->SetCellValue('J16', $this->data2_model->get_by_kesimpulan_freq('KB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K16', '=I16*J16');
	$worksheet->SetCellValue('G17', '4');
	$worksheet->SetCellValue('H17', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('I17', 1);
	$worksheet->SetCellValue('J17', $this->data2_model->get_by_kesimpulan_freq('TB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K17', '=I17*J17');
	$worksheet->SetCellValue('J18','=SUM(J14:J17)'); 
	$worksheet->SetCellValue('K18','=SUM(K14:K17)');
	$worksheet->mergeCells('J19:K19');
	$worksheet->mergeCells('J20:K20');
	$worksheet->SetCellValue('J19','=K18/J18');
	$worksheet->SetCellValue('J20','=J19*0.11');
	$worksheet->SetCellValue('G18', 'Jumlah');
	$worksheet->SetCellValue('G19', 'Nilai Rata Rata');
	$worksheet->SetCellValue('G20', 'Nilai Rata Rata Tertimbang');
	$worksheet->mergeCells('G18:I18');
	$worksheet->mergeCells('G19:I19');
	$worksheet->mergeCells('G20:I20');
	
	$idpertanyaan=7;
	$worksheet->SetCellValue('M13', 'No');
	$worksheet->SetCellValue('N13', 'Jawaban');
	$worksheet->SetCellValue('O13', 'Nilai Persepsi');
	$worksheet->SetCellValue('P13', 'Frekuensi');
	$worksheet->SetCellValue('Q13', 'Nilai Unsur');
	$worksheet->SetCellValue('M14', '1');
	$worksheet->SetCellValue('N14', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('O14', 4);
	$worksheet->SetCellValue('P14', $this->data2_model->get_by_kesimpulan_freq('SB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q14', '=O14*P14');
	$worksheet->SetCellValue('M15', '2');
	$worksheet->SetCellValue('N15', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('O15', 3);
	$worksheet->SetCellValue('P15', $this->data2_model->get_by_kesimpulan_freq('B',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q15', '=O15*P15');
	$worksheet->SetCellValue('M16', '3');
	$worksheet->SetCellValue('N16', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('O16', 2);
	$worksheet->SetCellValue('P16', $this->data2_model->get_by_kesimpulan_freq('KB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q16', '=O16*P16');
	$worksheet->SetCellValue('M17', '4');
	$worksheet->SetCellValue('N17', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('O17', 1);
	$worksheet->SetCellValue('P17', $this->data2_model->get_by_kesimpulan_freq('TB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q17', '=O17*P17');
	$worksheet->SetCellValue('P18','=SUM(P14:P17)'); 
	$worksheet->SetCellValue('Q18','=SUM(Q14:Q17)');
	$worksheet->mergeCells('P19:Q19');
	$worksheet->mergeCells('P20:Q20');
	$worksheet->SetCellValue('P19','=Q18/P18');
	$worksheet->SetCellValue('P20','=P19*0.11');
	$worksheet->SetCellValue('M18', 'Jumlah');
	$worksheet->SetCellValue('M19', 'Nilai Rata Rata');
	$worksheet->SetCellValue('M20', 'Nilai Rata Rata Tertimbang');
	$worksheet->mergeCells('M18:O18');
	$worksheet->mergeCells('M19:O19');
	$worksheet->mergeCells('M20:O20');
	
	$idpertanyaan=8;
	$worksheet->SetCellValue('A23', 'No');
	$worksheet->SetCellValue('B23', 'Jawaban');
	$worksheet->SetCellValue('C23', 'Nilai Persepsi');
	$worksheet->SetCellValue('D23', 'Frekuensi');
	$worksheet->SetCellValue('E23', 'Nilai Unsur');
	$worksheet->SetCellValue('A24', '1');
	$worksheet->SetCellValue('B24', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('C24', 4);
	$worksheet->SetCellValue('D24', $this->data2_model->get_by_kesimpulan_freq('SB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E24', '=C24*D24');
	$worksheet->SetCellValue('A25', '2');
	$worksheet->SetCellValue('B25', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('C25', 3);
	$worksheet->SetCellValue('D25', $this->data2_model->get_by_kesimpulan_freq('B',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E25', '=C25*D25');
	$worksheet->SetCellValue('A26', '3');
	$worksheet->SetCellValue('B26', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('C26', 2);
	$worksheet->SetCellValue('D26', $this->data2_model->get_by_kesimpulan_freq('KB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E26', '=C26*D26');
	$worksheet->SetCellValue('A27', '4');
	$worksheet->SetCellValue('B27', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('C27', 1);
	$worksheet->SetCellValue('D27', $this->data2_model->get_by_kesimpulan_freq('TB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('E27', '=C27*D27');
	$worksheet->SetCellValue('D28','=SUM(D24:D27)'); 
	$worksheet->SetCellValue('E28','=SUM(E24:E27)');
	$worksheet->mergeCells('D29:E29');
	$worksheet->mergeCells('D30:E30');
	$worksheet->SetCellValue('D29','=E28/D28');
	$worksheet->SetCellValue('D30','=D29*0.11');
	$worksheet->SetCellValue('A28', 'Jumlah');
	$worksheet->SetCellValue('A29', 'Nilai Rata Rata');
	$worksheet->SetCellValue('A30', 'Nilai Rata Rata Tertimbang');
	$worksheet->mergeCells('A28:C28');
	$worksheet->mergeCells('A29:C29');
	$worksheet->mergeCells('A30:C30');
	
	$idpertanyaan=9;
	$worksheet->SetCellValue('G23', 'No');
	$worksheet->SetCellValue('H23', 'Jawaban');
	$worksheet->SetCellValue('I23', 'Nilai Persepsi');
	$worksheet->SetCellValue('J23', 'Frekuensi');
	$worksheet->SetCellValue('K23', 'Nilai Unsur');
	$worksheet->SetCellValue('G24', '1');
	$worksheet->SetCellValue('H24', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('I24', 4);
	$worksheet->SetCellValue('J24', $this->data2_model->get_by_kesimpulan_freq('SB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K24', '=I24*J24');
	$worksheet->SetCellValue('G25', '2');
	$worksheet->SetCellValue('H25', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('I25', 3);
	$worksheet->SetCellValue('J25', $this->data2_model->get_by_kesimpulan_freq('B',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K25', '=I25*J25');
	$worksheet->SetCellValue('G26', '3');
	$worksheet->SetCellValue('H26', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('I26', 2);
	$worksheet->SetCellValue('J26', $this->data2_model->get_by_kesimpulan_freq('KB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K26', '=I26*J26');
	$worksheet->SetCellValue('G27', '4');
	$worksheet->SetCellValue('H27', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('I27', 1);
	$worksheet->SetCellValue('J27', $this->data2_model->get_by_kesimpulan_freq('TB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('K27', '=I27*J27');
	$worksheet->SetCellValue('J28','=SUM(J24:J27)'); 
	$worksheet->SetCellValue('K28','=SUM(K24:K27)');
	$worksheet->mergeCells('J29:K29');
	$worksheet->mergeCells('J30:K30');
	$worksheet->SetCellValue('J29','=K28/J28');
	$worksheet->SetCellValue('J30','=J29*0.11');
	$worksheet->SetCellValue('G28', 'Jumlah');
	$worksheet->SetCellValue('G29', 'Nilai Rata Rata');
	$worksheet->SetCellValue('G30', 'Nilai Rata Rata Tertimbang');
	$worksheet->mergeCells('G28:I28');
	$worksheet->mergeCells('G29:I29');
	$worksheet->mergeCells('G30:I30');
	
	$idpertanyaan=10;
	$worksheet->SetCellValue('M23', 'No');
	$worksheet->SetCellValue('N23', 'Jawaban');
	$worksheet->SetCellValue('O23', 'Nilai Persepsi');
	$worksheet->SetCellValue('P23', 'Frekuensi');
	$worksheet->SetCellValue('Q23', 'Nilai Unsur');
	$worksheet->SetCellValue('M24', '1');
	$worksheet->SetCellValue('N24', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('O24', 4);
	$worksheet->SetCellValue('P24', $this->data2_model->get_by_kesimpulan_freq('SB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q24', '=O24*P24');
	$worksheet->SetCellValue('M25', '2');
	$worksheet->SetCellValue('N25', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('O25', 3);
	$worksheet->SetCellValue('P25', $this->data2_model->get_by_kesimpulan_freq('B',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q25', '=O25*P25');
	$worksheet->SetCellValue('M26', '3');
	$worksheet->SetCellValue('N26', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('O26', 2);
	$worksheet->SetCellValue('P26', $this->data2_model->get_by_kesimpulan_freq('KB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q26', '=O26*P26');
	$worksheet->SetCellValue('M27', '4');
	$worksheet->SetCellValue('N27', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('O27', 1);
	$worksheet->SetCellValue('P27', $this->data2_model->get_by_kesimpulan_freq('TB',$date,$date2,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('Q27', '=O27*P27');
	$worksheet->SetCellValue('P28','=SUM(P24:P27)'); 
	$worksheet->SetCellValue('Q28','=SUM(Q24:Q27)');
	$worksheet->mergeCells('P29:Q29');
	$worksheet->mergeCells('P30:Q30');
	$worksheet->SetCellValue('P29','=Q28/P28');
	$worksheet->SetCellValue('P30','=P29*0.11');
	$worksheet->SetCellValue('M28', 'Jumlah');
	$worksheet->SetCellValue('M29', 'Nilai Rata Rata');
	$worksheet->SetCellValue('M30', 'Nilai Rata Rata Tertimbang');
	$worksheet->mergeCells('M28:O28');
	$worksheet->mergeCells('M29:O29');
	$worksheet->mergeCells('M30:O30');
	
	//judul
	$this->excel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setSize(20);
	$this->excel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);

	//tabel header
	$this->excel->getActiveSheet()->getStyle('A2:Q3')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A2:Q3')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A2:Q3')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A12:Q13')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A12:Q13')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A12:Q13')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A22:Q23')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A22:Q23')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A22:Q23')->getFont()->setBold(true);
	
	$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);


		
	if($filetype=='xlsx'){
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	if($filetype=='pdf'){
	$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
    $rendererLibrary = 'dompdf';
    $rendererLibraryPath = APPPATH.'/third_party/phpexcel/PHPExcel/Writer/'. $rendererLibrary;
    	if (!PHPExcel_Settings::setPdfRenderer(
        $rendererName,
        $rendererLibraryPath
    	)) {
        die(
        'Please set the $rendererName and $rendererLibraryPath values' .
        PHP_EOL .
        ' as appropriate for your directory structure'
        );
    	}
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
	header('Content-Type: application/pdf');
	}
	header('Content-Disposition: attachment;filename="Laporan Bulanan.'.$filetype.'"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	$this->excel->disconnectWorksheets();
	
	}
	
	function kesimpulan($filetype='',$date='')
	{
	if (empty($filetype)) $filetype='xlsx';
	if (empty($from)) $date=date('Y-m');
	//echo $filetype.$from.$to;
	$config['base_url']= site_url('export/kesimpulan/');
	$config['uri_segment']=4;
	
	$survey = $this->pertanyaan_model->get_by_bobot()->result();
	$this->excel->setActiveSheetIndex(0);
	$this->excel->getActiveSheet()->setTitle('Laporan Kesimpulan');
	$worksheet = $this->excel->getActiveSheet();
	$worksheet->SetCellValue('A1', 'Laporan Kesimpulan Periode '.date('M-Y',strtotime($date)));
	$worksheet->mergeCells('A1:C1');


	$this->excel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$worksheet->SetCellValue('A2', 'No');
	$worksheet->SetCellValue('B2', 'Ruang Lingkup');
	$worksheet->SetCellValue('C2', 'Nilai');
	$worksheet->SetCellValue('D2', 'Kategori');
	$worksheet->SetCellValue('E2', 'Peringkat');


	//judul
	$this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setSize(20);
	$this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

	//tabel header
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	

	$no = 1;
	$i=3;
	$totalindex=0;
	foreach ($survey as $value){
		
		$worksheet->setCellValue('A'.$i,$no);
		$worksheet->SetCellValue('B'.$i,$value->ruang_lingkup); 
		$worksheet->SetCellValue('C'.$i,round($this->data_model->get_by_kesimpulan($value->id,$datetime)->row()->rata*0.11,3)); 
		$worksheet->SetCellValue('D'.$i,$this->data_model->get_kesimpulan_rata($this->data_model->get_by_kesimpulan($value->id,$datetime)->row()->rata)->row()->value2);
		//$worksheet->setCellValue('E'.$i,'=RANK(C'.$i.',C3:C11');
		$totalindex=$totalindex+($this->data_model->get_by_kesimpulan($value->id,$datetime)->row()->rata*0.11);
		$i++;
		$no++;
	}
	
	for($t=3;$t<=11;$t++){
		$worksheet->setCellValue('E'.$t,'=RANK(C'.$t.',C3:C11)');
	}
	
	$this->excel->getActiveSheet()->getStyle('A3:' . $this->excel->getActiveSheet()->getHighestColumn() . $this->excel->getActiveSheet()->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');

	$worksheet->SetCellValue('G2', 'Nilai IKM');
	$worksheet->SetCellValue('G3', $totalindex*25);
	$worksheet->SetCellValue('G4', $this->data_model->get_kesimpulan($totalindex*25)->row()->value2);

	
	//isi tabel
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	
	
	$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);


		
	if($filetype=='xlsx'){
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	if($filetype=='pdf'){
	$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
    $rendererLibrary = 'dompdf';
    $rendererLibraryPath = APPPATH.'/third_party/phpexcel/PHPExcel/Writer/'. $rendererLibrary;
    	if (!PHPExcel_Settings::setPdfRenderer(
        $rendererName,
        $rendererLibraryPath
    	)) {
        die(
        'Please set the $rendererName and $rendererLibraryPath values' .
        PHP_EOL .
        ' as appropriate for your directory structure'
        );
    	}
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
	header('Content-Type: application/pdf');
	}
	header('Content-Disposition: attachment;filename="Laporan Kesimpulan.'.$filetype.'"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	$this->excel->disconnectWorksheets();
	
	}
	
	function kesimpulan2($filetype='',$date='',$date2='')
	{
	if (empty($filetype)) $filetype='xlsx';
	if (empty($date)) $date=date('Y-m-d');
	if (empty($date2)) $date2=date('Y-m-d');
	//echo $filetype.$from.$to;
	$config['base_url']= site_url('export/kesimpulan2/');
	$config['uri_segment']=4;
	
	$survey = $this->pertanyaan_model->get_by_bobot()->result();
	$this->excel->setActiveSheetIndex(0);
	$this->excel->getActiveSheet()->setTitle('Laporan Kesimpulan');
	$worksheet = $this->excel->getActiveSheet();
	$worksheet->SetCellValue('A1', 'Laporan Kesimpulan Periode '.date('d-M-Y',strtotime($date)).' s/d '.date('d-M-Y',strtotime($date2)));
	$worksheet->mergeCells('A1:E1');


	$this->excel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$worksheet->SetCellValue('A2', 'No');
	$worksheet->SetCellValue('B2', 'Ruang Lingkup');
	$worksheet->SetCellValue('C2', 'Nilai');
	$worksheet->SetCellValue('D2', 'Kategori');
	$worksheet->SetCellValue('E2', 'Peringkat');


	//judul
	$this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setSize(20);
	$this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

	//tabel header
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	

	$no = 1;
	$i=3;
	$totalindex=0;
	foreach ($survey as $value){
		
		$worksheet->setCellValue('A'.$i,$no);
		$worksheet->SetCellValue('B'.$i,$value->ruang_lingkup); 
		$worksheet->SetCellValue('C'.$i,round($this->data2_model->get_by_kesimpulan($value->id,$date,$date2)->row()->rata*0.11,3)); 
		$worksheet->SetCellValue('D'.$i,$this->data2_model->get_kesimpulan_rata($this->data_model->get_by_kesimpulan($value->id,$date,$date2)->row()->rata)->row()->value2);
		//$worksheet->setCellValue('E'.$i,'=RANK(C'.$i.',C3:C11');
		$totalindex=$totalindex+($this->data2_model->get_by_kesimpulan($value->id,$date,$date2)->row()->rata*0.11);
		$i++;
		$no++;
	}
	
	for($t=3;$t<=11;$t++){
		$worksheet->setCellValue('E'.$t,'=RANK(C'.$t.',C3:C11)');
	}
	
	$this->excel->getActiveSheet()->getStyle('A3:' . $this->excel->getActiveSheet()->getHighestColumn() . $this->excel->getActiveSheet()->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');

	$worksheet->SetCellValue('G2', 'Nilai IKM');
	$worksheet->SetCellValue('G3', $totalindex*25);
	$worksheet->SetCellValue('G4', $this->data2_model->get_kesimpulan($totalindex*25)->row()->value2);

	
	//isi tabel
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$this->excel->getActiveSheet()->getStyle('G2:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	
	
	$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);


		
	if($filetype=='xlsx'){
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	if($filetype=='pdf'){
	$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
    $rendererLibrary = 'dompdf';
    $rendererLibraryPath = APPPATH.'/third_party/phpexcel/PHPExcel/Writer/'. $rendererLibrary;
    	if (!PHPExcel_Settings::setPdfRenderer(
        $rendererName,
        $rendererLibraryPath
    	)) {
        die(
        'Please set the $rendererName and $rendererLibraryPath values' .
        PHP_EOL .
        ' as appropriate for your directory structure'
        );
    	}
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
	header('Content-Type: application/pdf');
	}
	header('Content-Disposition: attachment;filename="Laporan Kesimpulan.'.$filetype.'"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	$this->excel->disconnectWorksheets();
	
	}
	
	}
