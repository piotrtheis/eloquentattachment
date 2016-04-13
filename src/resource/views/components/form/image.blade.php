



 <div class="form-group  {{$errors->has($name) ? 'has-error' : null}}">
    {{ Form::label($name, null, ['class' => 'control-label']) }}
    
    <img 
    id="eloquent-attachment-image-preview" 
    class="eloquent-attachment-image-preview" 
    style="{{ !old('icon_path') ? "display: none" : "" }}"   
    src="{{ EloquentAttachment::getUrlPath() }}/{{ old($name . EloquentAttachment::getUpdatedFileSuffix()) }}">


    <div id="eloquent-attachment-image-preview-wrapper" class="eloquent-attachment-image-preview {{ old('icon_path') ? "hidden" : "" }}"></div>
    

    <span class="btn btn-default eloquent-attachment-btn-file">
    	{{ trans('attachment::attachment.browse-file') }} {{ Form::file($name)}}
    </span>

    {{ Form::hidden($name . EloquentAttachment::getUpdatedFileSuffix())}}

    <span class="help-block">{{$errors->first($name)}}</span>
</div>





   
   <script type="text/javascript">

        var input = document.querySelector('input[type=file]');

        input.addEventListener('change', function(){
            var preview = document.querySelector('#eloquent-attachment-image-preview');
            var file    = document.querySelector('input[type=file]').files[0];
            var reader  = new FileReader();

            var preview_wrapper = document.querySelector('#eloquent-attachment-image-preview-wrapper');

            reader.addEventListener("load", function () {
            preview.src = reader.result;
            preview.style.display = "block";
            preview_wrapper.style.display = "none";

          }, false);

          if (file) {
            reader.readAsDataURL(file);
          }
        })
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