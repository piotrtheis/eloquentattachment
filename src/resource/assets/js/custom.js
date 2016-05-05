 
 var input = document.querySelector('input[type=file]');


if(input != null){
     input.addEventListener('change', function() {
         var preview = document.querySelector('#eloquent-attachment-image-preview'); 
         var file   = document.querySelector('input[type=file]').files[0]; 
         var reader  = new FileReader();
         var preview_wrapper = document.querySelector('#eloquent-attachment-image-preview-wrapper'); 

         reader.addEventListener("load", function() {  
             preview.src = reader.result;
             preview.style.display = "block";
             preview_wrapper.style.display = "none"; 
         }, false); 


         if (file) {  
             reader.readAsDataURL(file); 
         }
     })
}