function increaseUrlClick(event)
{
    var divParent = event.target.parentElement.parentElement;
    var hiddenInput = divParent.querySelector('.pageUrlID');
    var id = hiddenInput.value;

    // do ajax post request.
    var url = 'updatePageUrlClick.php';
    response = fetch(url,
        {
            method:"POST", 
            headers:{"Content-Type":'application/json'},
            body:JSON.stringify({"pageUrlId":id})
        }
    )

    response
    .then(function(resp){console.log(resp); return resp.json();})
    .then(function(resp){
        console.log(resp);
    })
    .catch(err => console.log("increasing url click request failed", err));

    //event.preventDefault();
    return;
}