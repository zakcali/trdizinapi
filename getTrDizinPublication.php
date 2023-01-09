<?php
class getTrDizinPublication {
	public $trdizinid='', $doi='', $ArticleTitle='', $dergi='', $ISOAbbreviation='', $ISSN='', $eISSN='', $Year='', $Volume='', $Issue='', $StartPage='', $EndPage='', $yazarlar='', $PublicationType='', $AbstractText='', $dergiLinki='', $ArticleType='', $dikkat='';
	public $yazarS=0;

	function __construct() {
		}
		
	final function trDizinPublication ($numara) {
			
	$preText="https://search.trdizin.gov.tr/yayin/detay/";
	$postText="?view=json";
	$url = $preText.$numara.$postText;
	$headers = get_headers($url);
	if(substr($headers[0], 9, 3) != "200") {
		$this->dikkat='yayın bulunamadı';   
		return;
		}		
	$icerik=@file_get_contents($url);
//	echo $icerik;
// On Windows, uncomment the following line in php.ini, and restart the Apache server:
// extension=mbstring
// extension=php_mbstring.dll
	$html= mb_convert_encoding($icerik, 'HTML-ENTITIES', "UTF-8");
	$strippedHtml=str_replace ('\\r','',$html);
	$cisim1=json_decode ($strippedHtml);
	$cisim=$cisim1->records[0];
//	print_r($cisim);
// trdizin numarası
	if (isset ($cisim->id)) 
		$this->trdizinid=$cisim->id;
// Makalenin başlığı
	if (isset ($cisim->title)) 
		$this->ArticleTitle = $cisim->title;
// yayın türü
	if (isset ($cisim->docType)) {
		$this->PublicationType = $cisim->docType;
		switch ($cisim->docType) {
			case 'paper':
				$this->PublicationType ='Makale';
				break;
			case 'project':
				$this->PublicationType ='Proje';
				break;
				}
	}
// makale türü
	if (isset ($cisim->publicationType)) {
		$this->ArticleType = $cisim->publicationType;
		switch ($cisim->publicationType) {
			case 'RESEARCH':
				$this->ArticleType = 'Araştırma Makalesi';	
				break;
			case 'LETTER_TO_EDITOR':
				$this->ArticleType = 'Editöre Mektup';	
				break;
			case 'FACT_PRESENTATION':
				$this->ArticleType = 'Olgu Sunumu';	
				break;
			case 'COMPILATION':
				$this->ArticleType = 'Derleme';	
				break;
			case 'BOOK_PRESENTATION':
				$this->ArticleType = 'Kitap Tanıtımı';	
				break;
			case 'TRANSLATION':
				$this->ArticleType = 'Çeviri';	
				break;
			case 'EDITORIAL':
				$this->ArticleType = 'Editoryal';	
				break;
			case 'LETTER':
				$this->ArticleType = 'Mektup';	
				break;
			case 'REPORT':
				$this->ArticleType = 'Bildiri';	
				break;
			case 'SHORT_REPORT':
				$this->ArticleType = 'Kısa Bildiri';	
				break;
			case 'MEETING_SUMMARY':
				$this->ArticleType = 'Toplantı Özetleri';	
				break;
			case 'CORRECTION':
				$this->ArticleType = 'Düzeltme';	
				break;
			case 'OTHER':
				$this->ArticleType = 'Diğer';	
				break;
		}
	}
// Özet
	if (isset ($cisim->abstract))
		$this->AbstractText = $cisim->abstract;
// doi
	if (isset ($cisim->publicationNumber))
		$this->doi = $cisim->publicationNumber;
// Dergi ismi
	if (isset ($cisim->journalName))
		$this->dergi = $cisim->journalName;
// Dergi linki
	if (isset ($cisim->journalCode))
		$this->dergiLinki = $cisim->journalCode;
// Aldığı atıf sayısı
// dergi kısa ismi
// PMID
// issn
	if (isset ($cisim->issn)) 
		$this->ISSN = $cisim->issn;
// issn
	if (isset ($cisim->eissn))
		$this->eISSN = $cisim->eissn;
//Yıl
	if (isset ($cisim->issue->issue_year))
		$this->Year=$cisim->issue->issue_year;
// cilt
	if (isset ($cisim->issue->issueVolume))
		$this->Volume=$cisim->issue->issueVolume;
// sayı
	if (isset ($cisim->issue->issueNumber))
		$this->Issue=$cisim->issue->issueNumber;
// başlangıç sayfası
	if (isset ($cisim->startPage))
		$this->StartPage = $cisim->startPage;
// bitiş sayfası
	if (isset ($cisim->endPage))
		$this->EndPage = $cisim->endPage;
// yazar sayısı
	$this->yazarS=0;
// yazarlar
	$this->yazarlar="";
	foreach ($cisim->author as $yazar) {
		$this->yazarlar.=$yazar->authorNameInPaper.", ";
		$this->yazarS+=1;
			}
	$this->yazarlar=substr ($this->yazarlar,0,-2);

	} // final function trDizinPublication

}