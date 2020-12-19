# tiny-searchEngine

## introducction:
this project was build with the aim to enhance my knowledge with the HTTP protocol (which it did)
and practice a little bit of PHP and writing a clean code that could be understood by others (I hope that I did).

## start the project:
as easy as cloning the repo inside htdocs file of xampp
then lunch xampp and mysql
and open this url
http://localhost/tiny-searchEngine/index.php

## components of the project
* crawler
  * urlResolver 
    this class will help in converting the hyper references in the anchor tag element to absolute url 
    to be crawled there is many cases that a href could be related to the current url of the page 
    or not related at all 
  * urlFilter 
    this class will allow the crawler discard some bad urls
    bad urls are 
      * url that don't return 200 okay as response 
      * url that ask for more than 1 redirection operation 
      * url that will execute java script file 
      * url with fragement that point to another position in the same page
      
  
