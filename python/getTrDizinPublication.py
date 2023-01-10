# trdizinapi V1.1, by Zafer Akçalı

import urllib.request as req
from urllib.error import URLError, HTTPError
import certifi
import ssl
import json

class getTrDizinPublication: 
    def __init__(self):
        self.yazarlar=''; self.trdizinid=''; self.doi=''; self.ArticleTitle=''; self.dergi=''; self.ISOAbbreviation=''; self.ISSN=''; self.eISSN=''; self.Year=''; self.Volume=''; self.Issue=''; self.StartPage=''; self.EndPage=''; self.PublicationType=''; self.AbstractText=''; self.dergiLinki=''; self.ArticleType=''; self.dikkat=''; 
        self.yazarS=0             
     
    def trDizinPublication (self,numara):
        self.__init__()  # değerleri tekrar sıfırla
        preText = "https://search.trdizin.gov.tr/yayin/detay/"
        postText = "?view=json"
        url = preText+numara+postText
        #print("hedef:", url)
# https://stackoverflow.com/questions/27835619/urllib-and-ssl-certificate-verify-failed-error
        try:
            response = req.urlopen(url, context=ssl.create_default_context(cafile=certifi.where()))
        except HTTPError as e:
            self.dikkat="yayın bulunamadı"
            return
        except URLError as e:
            self.dikkat="bağlantı kurulamadı"
            return
        self.dikkat="yayın bulundu"
        
        bytecode = response.read ()
        htmlstr = bytecode.decode().replace ("\\r"," ") # carriage return \r karakterlerini çıkart
# print (htmlstr)
        trDic=json.loads (htmlstr) 
        for key,value in trDic['records'][0].items():
#    print("The key and value are {} = {}".format(key, value))
#    print ()
            if key == 'title':
                self.ArticleTitle = value 
            elif key == 'id':
                self.trdizinid = value 
            elif key == 'abstract':
                self.AbstractText = value 
            elif key == 'publicationNumber':
                self.doi = value            
            elif key == 'journalName':
                self.dergi = value  
            elif key == 'journalCode':
                self.dergiLinki = value 
            elif key == 'issn':
                self.ISSN = value             
            elif key == 'eissn':
                self.eISSN = value   
            elif key == 'startPage':
                self.StartPage = value
            elif key == 'endPage':
                self.EndPage = value

            elif key == 'docType':
                if value == "paper":
                    self.PublicationType = "Makale"
                elif value == "project":
                    self.PublicationType = "Proje"
                elif value:
                    self.PublicationType = value
            elif key == 'publicationType':
                if value == "RESEARCH":
                    self.ArticleType = "Araştırma Makalesi"
                elif value == "LETTER_TO_EDITOR":
                    self.ArticleType = "Editöre Mektup"
                elif value == "FACT_PRESENTATION":
                    self.ArticleType = "Olgu Sunumu"
                elif value == "COMPILATION":
                    self.ArticleType = "Derleme"
                elif value == "BOOK_PRESENTATION":
                    self.ArticleType = "Kitap Tanıtımı"
                elif value == "TRANSLATION":
                    self.ArticleType = "Çeviri"
                elif value == "EDITORIAL":
                    self.ArticleType = "Editoryal"
                elif value == "LETTER":
                    self.ArticleType = "Mektup"
                elif value == "REPORT":
                    self.ArticleType = "Bildiri"
                elif value == "SHORT_REPORT":
                    self.ArticleType = "Kısa Bildiri"
                elif value == "MEETING_SUMMARY":
                    self.ArticleType = "Toplantı Özetleri"
                elif value == "CORRECTION":
                    self.ArticleType = "Düzeltme"
                elif value == "OTHER":
                    self.ArticleType = "Diğer"
                elif value:
                    self.ArticleType = value
 
            elif key == "issue":
                for key2, value2 in value.items():
                    if key2 == "issue_year":
                        self.Year = value2   
                    elif key2 == "issueVolume":
                        self.Volume = value2
                    elif key2 == "issueNumber":
                        self.Issue = value2     
            elif key == "author":
                authors = "";
                for i in range (len(value)):
                    for key3, value3 in value[i].items():
                        if key3 == "authorNameInPaper":
                            authors = authors+ value3 + ", "
                            self.yazarS=self.yazarS+1
                self.yazarlar = authors[:-2]