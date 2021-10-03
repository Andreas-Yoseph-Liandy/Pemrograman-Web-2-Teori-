//GENRE
function deleteGenre(id){
   let confirmation = window.confirm("Are you sure want to delete ?");
   if(confirmation){
    window.location = "?mn=genre&tok=del&did="+id;
   }
}

const editGenre = (id) =>{
    window.location = "?mn=genre_update&uid="+id;
}

//BOOK
function deleteBook(isbn){
    let confirmation = window.confirm("Are you sure want to delete ?");
    if(confirmation){
     window.location = "?mn=book&tok=del&did="+isbn;
    }
 }
 
 const editBook = (isbn) =>{
     window.location = "?mn=book_update&uid="+isbn;
 }
 

