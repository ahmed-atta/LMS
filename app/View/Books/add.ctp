<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#fileUpload").on('change', function () {

	    var imgPath = $(this)[0].value;
	    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

	    if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
	        if (typeof (FileReader) != "undefined") {

	            var image_holder = $("#image-holder");
	            image_holder.empty();

	            var reader = new FileReader();
	            reader.onload = function (e) {
	                $("<img />", {
	                    "src": e.target.result,
	                        "class": "thumb-image"
	                }).appendTo(image_holder);

	            }
	            image_holder.show();
	            reader.readAsDataURL($(this)[0].files[0]);
	        } 
	    } else {
	        alert("Pls select only images");
	    }
	});
});
</script>
<h1>Add Book</h1>
<?php
echo $this->Form->create('Book', array('type' => 'file'));
echo $this->Form->input('title');
echo $this->Form->input('author_name');
echo $this->Form->input('picture', array('type' => 'file','id'=>"fileUpload"));
?>
<div id="image-holder"></div>
<?php
echo $this->Form->input('download', array('type' => 'file'));
echo $this->Form->select('category_id',$categories);

echo $this->Form->end('Save Post');
?>