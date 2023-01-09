import urllib.request as req
import json
yazarlar="";
yazarS=0;
preText = "https://search.trdizin.gov.tr/yayin/detay/"
postText = "?view=json"
numara = input("trdizin numarasını giriniz:")
url = preText+numara+postText
print("hedef:", url)
response = req.urlopen(url)
bytecode = response.read ()
htmlstr = bytecode.decode().replace ("\\r","") # carriage return \r karakterlerini çıkart
# print (htmlstr)
trDic=json.loads (htmlstr) 
for key,value in trDic['records'][0].items():
#    print("The key and value are {} = {}".format(key, value))
#    print ()
    if key == 'title':
       print ("ArticleTitle = ", (value)) 
    elif key == 'id':
        print ("trdizinid = ", (value))
    elif key == 'docType':
        if value == "paper":
            print ("PublicationType = "+"Makale")
        elif value == "project":
            print ("PublicationType = "+"Proje")
        elif value:
            print ("PublicationType = ", (value))
    elif key == 'publicationType':
        if value == "RESEARCH":
            print ("ArticleType = "+"Araştırma Makalesi")
        elif value == "LETTER_TO_EDITOR":
            print ("ArticleType = "+"Editöre Mektup")
        elif value == "FACT_PRESENTATION":
            print ("ArticleType = "+"Olgu Sunumu")
        elif value == "COMPILATION":
            print ("ArticleType = "+"Derleme")
        elif value == "BOOK_PRESENTATION":
            print ("ArticleType = "+"Kitap Tanıtımı")
        elif value == "TRANSLATION":
            print ("ArticleType = "+"Çeviri")
        elif value == "EDITORIAL":
            print ("ArticleType = "+"Editoryal")
        elif value == "LETTER":
            print ("ArticleType = "+"Mektup")
        elif value == "REPORT":
            print ("ArticleType = "+"Bildiri")
        elif value == "SHORT_REPORT":
            print ("ArticleType = "+"Kısa Bildiri")
        elif value == "MEETING_SUMMARY":
            print ("ArticleType = "+"Toplantı Özetleri")
        elif value == "CORRECTION":
            print ("ArticleType = "+"Düzeltme")
        elif value == "OTHER":
            print ("ArticleType = "+"Diğer")
        elif value:
            print ("ArticleType = ", (value))
    elif key == 'abstract':
        print ("AbstractText = ", (value))
    elif key == 'publicationNumber':
        print ("doi = ", (value))
    elif key == 'journalName':
        print ("dergi = ", (value))
    elif key == 'journalCode':
        print ("dergiLinki = ", (value))
    elif key == 'issn':
        print ("ISSN = ", (value))
    elif key == 'eissn':
        print ("eISSN = ", (value))
    elif key == 'startPage':
        print ("StartPage = ", (value))
    elif key == 'endPage':
        print ("EndPage = ", (value))
        
    elif key == "issue":
        for key2, value2 in value.items():
            if key2 == "issue_year":
                print ("Year = ", (value2))   
            elif key2 == "issueVolume":
                print ("Volume = ", (value2))
            elif key2 == "issueNumber":
                print ("Issue = ", (value2))     
    elif key == "author":
        authors = "";
        for i in range (len(value)):
            for key3, value3 in value[i].items():
                if key3 == "authorNameInPaper":
                    authors = authors+ value3 + ", "
                    yazarS=yazarS+1
        yazarlar = authors[:-2]
        print ("Yazarlar = ", (yazarlar))
        print ("Yazar sayısı = ", (yazarS))