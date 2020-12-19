var requestNumber = 2;
var imageGrid = null;
var msnry = null;

function addImages(response)
{
    response.forEach(resp => {
        var url = resp['imageUrl'];
        var alt = resp['alt'];
        var title = resp['title'];
        var displayText = "";
        if(alt)
            displayText = alt;
        else if(title)
            displayText = title;
        else 
            displayText = url;

        var imgElement = document.createElement('div');
        imgElement.setAttribute('class', 'gridItem');
        imgElement.innerHTML = ` 
                            <a href='${url}'>
                                <img src='${url}'>
                                <span class='details'>${displayText}</span>
                            </a>`;
                        
        imageGrid.appendChild(imgElement);
        msnry.appended(imgElement);
    });
    requestNumber +=1;
    msnry.layout();
    return ;
}

function loadImages()
{
    var searchTerm = document.getElementById('searchTerm').value;
    var url = `getImagesApi.php?term=${searchTerm}&type=images&reqNum=${requestNumber}`;

    console.log('url: ', url);

    fetch(url)
    .then(response => response.json())
    .then(response => addImages(response))
    .catch(err => console.log("failure", err));

}

function handleScroll(event)
{
    scrollHeight = document.documentElement.scrollHeight;
    currentPosition = window.scrollY;

    console.log(scrollHeight, window.scrollY);
    if(scrollHeight - currentPosition < 800)
        loadImages();
}


document.addEventListener('DOMContentLoaded', function(){
    console.log("document loaded");

    // attach events 
    var type = document.getElementsByClassName('active')[0].dataset.type;
    if(type == 'images'){
        window.addEventListener('scroll', handleScroll);
        imageGrid = document.getElementsByClassName('imageGrid')[0];

        // initialize misonary 
        msnry = new Masonry(imageGrid, {
            itemSelector:'.gridItem', 
            columnWidth: 200
        });
    }
})



