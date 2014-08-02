<div id="image_settings_modal_holder">
    <link rel="stylesheet" href="<?php print(INCLUDES_URL);  ?>toolbar/editor_tools/imageeditor/cropper.min.css" type="text/css" />
    <script src="<?php print(INCLUDES_URL);  ?>toolbar/editor_tools/imageeditor/cropper.min.js"></script>

  <style scoped="scoped">

  #the-image-holder{
    position: relative;
    text-align: center;
    max-width: 100%;
    height: 300px;
  }

  #the-image-holder img{
    max-width: 100%;
    max-height: 100%;
    box-shadow:0 0 4px -2px #000;
    -webkit-box-shadow:0 0 4px -1px #000;
  }

  </style>

  <div class='image_settings_modal'>



        <div id="the-image-holder"><!-- Image will be placed here --></div>
   <div class="mw-ui-box-content">

      <div class="mw-ui-field-holder">
        <div class="mw-ui-btn-nav pull-left" style="margin-right:12px">


          <span class="mw-ui-btn mw-ui-btn-icon" onclick="mw.createCropTool();">
            <span class="mw-icon-crop"></span>
          </span>
          <span class="mw-ui-btn mw-ui-btn-icon" onclick="mw.image.rotate(mw.image.current);mw.image.current_need_resize = true;mw.$('#mw_image_reset').removeClass('disabled')">
            <span class="mw-icon-ios7-refresh-empty"></span>
          </span>
          <span class="mw-ui-btn disabled" id="mw_image_reset"><?php _e("Reset"); ?></span>
        </div>



        <div class="mw-dropdown mw-dropdown-default pull-left" id="" style="width: 140px;">
          <span class="mw-dropdown-value mw-ui-btn mw-dropdown-val"><?php _e("Effects"); ?></span>
          <div class="mw-dropdown-content" style="display: none;">
            <ul>
              <li value="vintage" onclick="mw.image.vintage(mw.image.current);mw.$('#mw_image_reset').removeClass('disabled')"><?php _e("Vintage Effect"); ?></li>
              <li value="grayscale" onclick="mw.image.grayscale(mw.image.current);mw.$('#mw_image_reset').removeClass('disabled')"><?php _e("Grayscale"); ?></li>
            </ul>
          </div>
        </div>



      </div>


      <div class="mw-ui-row-nodrop" style="padding-bottom: 20px;">
          <div class="mw-ui-col">
            <div class="mw-ui-col-container">
                <label class="mw-ui-label"><?php _e("Image Description"); ?></label>
                <textarea class="mw-ui-field w100" placeholder='<?php _e("Enter Description"); ?>' id="image-title"></textarea>
            </div>
          </div>
          <div class="mw-ui-col">
            <div class="mw-ui-col-container">
                <label class="mw-ui-label"><?php _e("Image Alternative Text"); ?> <span class="mw-icon-help-outline mwahi tip" data-tipposition="bottom-right" data-tip="<?php _e("Text that appears if image fails to load. (Important for Search Engines)"); ?>"></span></label>
                <textarea class="mw-ui-field w100" placeholder='<?php _e("Enter Description"); ?>' id="image-alt"></textarea>
            </div>
          </div>
      </div>
      <span class='mw-ui-btn mw-ui-btn-invert mw-ui-btn-saveIMG pull-right'><?php _e("Update"); ?></span>
      </div>
  </div>
</div>

<script>


mw.createCropTool = function(){
   cropImage =  $('#mwimagecurrent');
   cropImage.cropper({
        dragCrop:false,
        autoCrop:true,
        done: function(data) {
          if(!this.CropToolRendered){
               this.CropToolRendered = true;
               mw.$('.cropper-dragger', cropImage[0].parentNode).bind('dblclick', function(){
                  var data = cropImage.cropper("getData");
                 console.dir(data)
                  var canvas = document.createElement('canvas');
                      canvas.width = data.width,
                      canvas.height = data.height;
                  var context = canvas.getContext('2d');
                  context.drawImage(cropImage[0], data.x, data.y, data.width, data.height, 0, 0, data.width, data.height);
                  var newsrc = canvas.toDataURL();
                  var newimg = new Image();
                  newimg.src = newsrc;
                  newimg.id = 'mwimagecurrent';
                  mw.$(".cropper-container", cropImage[0].parentNode).remove();
                  cropImage.replaceWith(newimg);
                  mw.image.current = newimg;
          });
          }

        }
    });
}

$(mwd).ready(function(){


   if(self !== parent && !!parent.mw.image.currentResizing){
        theImage = parent.mw.image.currentResizing[0];
   }




 mw.image.current_need_resize = false;

         var src = theImage.src,
            title = theImage.title,
            alt = theImage.alt;

        mw.$("#the-image-holder").html("<img id='mwimagecurrent' src='"+src+"' />");

        mw.image.current_original = src;

        mw.image.current = mwd.querySelector("#mwimagecurrent");

        mw.$("#image-title").val(title);
        mw.$("#image-alt").val(alt);

        mw.$(".mw-ui-btn-saveIMG").click(function(){
          theImage.src = mw.image.current.src;
          theImage.align = mw.image.current_align;
          theImage.title = mw.$("#image-title").val();
          theImage.alt = mw.$("#image-alt").val();
          if(mw.image.current_need_resize){
              mw.image.preload(mw.image.current.src, function(w,h){
                   theImage.style.width = w+'px';
                   theImage.style.height = 'auto';
                   parent.mw.wysiwyg.normalizeBase64Image(theImage);
                   parent.mwd.getElementById('mw-image-settings-modal').modal.remove();
              });
          }

        });

        mw.$("#mw_image_reset").click(function(){
          if(!$(this).hasClass("disabled")){
            mw.image.current.src = mw.image.current_original;
            mw.image.current_need_resize = true;
          }
        });


 });

</script>