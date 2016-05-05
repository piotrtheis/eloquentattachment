 <div class="form-group  {{$errors->has($name) ? 'has-error' : null}}">
    {{ Form::label($name, null, ['class' => 'control-label']) }}
    

    <img id="eloquent-attachment-image-preview"
        class="eloquent-attachment-image-preview"
        style="{{ (!old('icon_path') && !$value) ? "display: none" : "" }}"    
        src="<?php
            if((bool)old($name . EloquentAttachment::getUpdatedFileSuffix()))
            {
                echo EloquentAttachment::getUrlPath() . '/' . old($name . EloquentAttachment::getUpdatedFileSuffix());                    
            } else {
                echo $value;
            }
        ?>">


    <div id="eloquent-attachment-image-preview-wrapper" class="eloquent-attachment-image-preview {{ (old('icon_path') || $value) ? "hidden" : "" }}"></div>

    <span class="btn btn-default eloquent-attachment-btn-file">
        {{ trans('attachment::attachment.browse-file') }}
        <input type="file" name="{{ $name }}" accept="image/*" onchange='openFile(event)'>
    </span>

    {{ Form::hidden($name . EloquentAttachment::getUpdatedFileSuffix(), $value, ['id' => 'eloquent-attachment-image-url-wrapper'])}}


    <span class="help-block">{{$errors->first($name)}}</span>
</div>


<script>
  var openFile = function(event) {
    var input = event.target;
    var reader = new FileReader();
    var preview = document.querySelector('#eloquent-attachment-image-preview');
    var preview_wrapper = document.querySelector('#eloquent-attachment-image-preview-wrapper');


    reader.onload = function(){
        var dataURL = reader.result;
        preview.src = dataURL;

        preview.style.display = "block";
        preview_wrapper.style.display = "none";

    };
    reader.readAsDataURL(input.files[0]);
  };
</script>

   <style type="text/css">
        .eloquent-attachment-btn-file {
		    position: relative;
		    overflow: hidden;
		}
		.eloquent-attachment-btn-file input[type=file] {
		    position: absolute;
		    top: 0;
		    right: 0;
		    min-width: 100%;
		    min-height: 100%;
		    font-size: 100px;
		    text-align: right;
		    filter: alpha(opacity=0);
		    opacity: 0;
		    outline: none;
		    background: white;
		    cursor: inherit;
		    display: block;
		}
        
        .eloquent-attachment-image-preview{
            min-height: 200px;
            width: 100%;
            border: 1px solid #CACACA;
            border-radius: 5px;
            margin-bottom: 10px;
        }

	</style>