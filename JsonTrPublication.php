<?php
class getJsonTrPublication {
	public $trdizinid='', $doi='', $ArticleTitle='', $dergi='', $ISOAbbreviation='', $ISSN='', $eISSN='', $Year='', $Volume='', $Issue='', $StartPage='', $EndPage='', $yazarlar='', $PublicationType='', $AbstractText='', $dergiLinki='', $ArticleType='', $dikkat='';
	public $yazarS=0;

	    function __construct() {
		}
		
		final function trPublication ($numara) {
			
		$preText="https://search.trdizin.gov.tr/yayin/detay/";
		$url = $preText.$numara.'?view=json';
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
	$cisim1=json_decode ($html);
	$cisim=$cisim1->records[0];
//	print_r($cisim);
// trdizin numarası
			if (isset ($cisim->id)) 
				$this->trdizinid=$cisim->id;
// Makalenin başlığı
			if (isset ($cisim->title)) 
				$this->ArticleTitle = $cisim->title;
// yayın türü
			if (isset ($cisim->docType))
				$this->PublicationType = $cisim->docType;
				if ($cisim->docType == 'paper')
					$this->PublicationType ='Makale';
				else if ($cisim->docType == 'project')
					$this->PublicationType ='Proje';
// makale türü
			if (isset ($cisim->publicationType)) {
				$this->ArticleType = $cisim->publicationType;
				if ($cisim->publicationType == 'RESEARCH')
					$this->ArticleType = 'Araştırma Makalesi';
				else if ($cisim->publicationType == 'LETTER_TO_EDITOR')
					$this->ArticleType = 'Editöre Mektup';
				else if ($cisim->publicationType == 'FACT_PRESENTATION')
					$this->ArticleType = 'Olgu Sunumu';
				else if ($cisim->publicationType == 'COMPILATION')
					$this->ArticleType = 'Derleme';
				else if ($cisim->publicationType == 'BOOK_PRESENTATION')
					$this->ArticleType = 'Kitap Tanıtımı';
				else if ($cisim->publicationType == 'TRANSLATION')
					$this->ArticleType = 'Çeviri';
				else if ($cisim->publicationType == 'EDITORIAL')
					$this->ArticleType = 'Editoryal';
				else if ($cisim->publicationType == 'LETTER')
					$this->ArticleType = 'Mektup';
				else if ($cisim->publicationType == 'REPORT')
					$this->ArticleType = 'Bildiri';
				else if ($cisim->publicationType == 'SHORT_REPORT')
					$this->ArticleType = 'Kısa Bildiri';
				else if ($cisim->publicationType == 'MEETING_SUMMARY')
					$this->ArticleType = 'Toplantı Özetleri';
				else if ($cisim->publicationType == 'CORRECTION')
					$this->ArticleType = 'Düzeltme';
				else if ($cisim->publicationType == 'OTHER')
					$this->ArticleType = 'Diğer';
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
				$this->yazarS=$this->yazarS+1;
					}
			$this->yazarlar=substr ($this->yazarlar,0,-2);

	} // final function trPublication

}