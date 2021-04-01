<script>
//TO ACTIVATE THIS CODE
//PUT THIS CODE ON EVERY TEXTBOX YOU WANT
//oninput="javascript:validate(this.id,this.value)"
function validate(id,value) {
     // var rgx = /^[a-zA-Z0-9 ]*$/; // ACCEPT LETTER,SPACE AND NUMBER
    var rgx = /^[a-zA-Z0-9-+&.!$ñ\s]*$/; // ACCEPT LETTER, NUMBER AND DASH
    
    if(!rgx.test(value)) {
       swal('That special character is not allowed','','error');
       
       var filtered_input = value.replace(/[^a-zA-Z0-9-+&.!$ñ\s ]/g, "");
       
       document.getElementById(id).value = filtered_input;
       numberVar.focus();
    } 
}
</script>