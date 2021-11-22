$(document).ready(function() {
$(".imgPreview").change(function() {
  readURL(this);
});

$(".url").focusout(function(e){
var prefix = 'https://';
var s=this.value;
if(s.length){
if (s.substr(0, prefix.length) !== prefix){
s = prefix + s;
}
this.value=s;
}
});




});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('.'+input.id).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

