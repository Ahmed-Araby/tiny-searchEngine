# tiny-searchEngine

## introducction:
this project was build with the aim to enhance my knowledge with the HTTP protocol (which it did)
and practice a little bit with PHP and writing a clean code that could be understood by others (I hope that I did).

## start the project:
* for using the searchEngine webSite
  as easy as cloning the repo into htdocs file of xampp

  then lunch xampp and mysql
  and open this url

  http://localhost/tiny-searchEngine/index.php
* for crawling the web 
  * you have to provide some seed urls into the seed.txt file 
  * then run "php launchCrawler.php" file from the command line withing the project folder.

## components of the project
* crawler
  * urlResolver 
    this class will help in converting the hyper references in the anchor tag element to absolute url 
    to be crawled there are many cases that a href could be related to the current url of the page 
    or not related at all 
  * urlFilter 
    this class will allow the crawler to discard some bad urls/href
    bad urls/href are 
      * url that don't return 200 okay as response 
      * url that ask for more than 1 redirection operation 
      * href that will execute javascript function 
      * url with fragement that point to another position in the same page
  * httpRequester
    this class will take absolute url and make http GET request using "CURL" and return the html response
    of this url and some information about the headers this class can follow redirection requests
  * html parser
    using domDocument class of php this class will return
      * hrefs of the anchro tags 
      * hrefs of the image 
      * some meta data of the images 
      * some meta data of the page 
  * dataBasePersistance
    this class will save the information comming from html parser into the data base 
    for indexing (not implemented untill now ) and retrival.
  * crawler 
    this class implement very simple "BFS" graph traversal algorithm that will crawle the web
    with the help of all the components mentioned upove
* simple webSite
  for the user to enter the search term and get the results, the site provide search results as links to webPages and seach results as images
  that are related to the search term.
  
## highlights
* image search results page is infinitie scroll like google image search result page, implemented 
  using js in the front end that will listen to the event of reaching the end of the page then 
  ask the server for more search results.
* masonry java script library was used to provide the UI grid lay out of the images result page
  https://masonry.desandro.com/
* on the sites result page a pagination system was implemented just like the one at google page.


## TO DO
* currently the webCrawler is single thereded, so I plan to implement a multi threded web crawler (very soon)
  may be using python or java who knows!!! .
* implement a page rank algorithm to provide a good search results.
  
