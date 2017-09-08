 
 

+(function ($) {

  'use strict';

  var console = window.console || { log: function () {} };

  function CropAvatar(module,fieldname,width,height) { 
	  if ($('#'+fieldname+'_crop_avatar').length > 0)
	  { 
		  this.$loading = $('.upload_loading'); 
		  
	      this.$container = $('#'+fieldname+'_crop_avatar'); 
	      this.$avatarView = this.$container.find('.avatar-view');
	      this.$avatar = this.$avatarView.find('img.avatar-image');
		  this.$avatar_input = this.$container.find('#'+fieldname);
		  this.$avatar_close_btn = this.$container.find('#close_btn');
		  
		  this.$width = parseInt(width,10);
		  this.$height = parseInt(height,10);
		  
		  if ($('#'+module+'_upload_dialog').length > 0)
		  {
			  var $dialog = $('#'+module+'_upload_dialog');
			  
		      this.$avatarForm = $dialog.find('.avatar-form');
		      this.$avatarUpload = this.$avatarForm.find('.avatar-upload');
		      this.$avatarSrc = this.$avatarForm.find('.avatar-src');
		      this.$avatarData = this.$avatarForm.find('.avatar-data');
		      this.$avatarInput = this.$avatarForm.find('.avatar-input'); 
		      this.$avatarBtns = this.$avatarForm.find('.avatar-btns'); 
		      this.$avatarWrapper = $dialog.find('.avatar-wrapper');
		      this.$avatarPreview = $dialog.find('.avatar-preview'); 
			  
			  if ($('#'+module+'_upload_btn_dialog').length > 0)
			  {
				  var $btndialog = $('#'+module+'_upload_btn_dialog');
			   
			      this.$avatarSave = $btndialog.find('.avatar-save');  
			  }   
		      this.init(); 
		      console.log(this);
		  }  
	  } 
  }

  CropAvatar.prototype = {
    constructor: CropAvatar,

    support: {
      fileList: !!$('<input type="file">').prop('files'),
      blobURLs: !!window.URL && URL.createObjectURL,
      formData: !!window.FormData
    },

    init: function () {
      this.support.datauri = this.support.fileList && this.support.blobURLs;

      if (!this.support.formData) {
        this.initIframe();
      }

      this.initTooltip(); 
      this.addListener();
    },

    addListener: function () { 
      this.$avatarInput.on('change', $.proxy(this.change, this));
      this.$avatarForm.on('submit', $.proxy(this.submit, this));
      this.$avatarBtns.on('click', $.proxy(this.rotate, this));
	  this.$avatar_close_btn.on('click', $.proxy(this.btnclose, this));
    },

    initTooltip: function () {
      this.$avatarView.tooltip({
        placement: 'bottom'
      });
    },

  
    initPreview: function () {
      var url = this.$avatar.attr('src'); 
      this.$avatarPreview.empty().html('<img src="' + url + '">');
    },

    initIframe: function () {
      var target = 'upload-iframe-' + (new Date()).getTime(),
          $iframe = $('<iframe>').attr({
            name: target,
            src: ''
          }),
          _this = this;

      // Ready ifrmae
      $iframe.one('load', function () {

        // respond response
        $iframe.on('load', function () {
          var data;

          try {
            data = $(this).contents().find('body').text();
          } catch (e) {
            console.log(e.message);
          }

          if (data) {
            try {
              data = $.parseJSON(data);
            } catch (e) {
              console.log(e.message);
            }

            _this.submitDone(data);
          } else {
            _this.submitFail('图片文件上传失败!');
          }

          _this.submitEnd();

        });
      });

      this.$iframe = $iframe;
      this.$avatarForm.attr('target', target).after($iframe.hide());
    },

     

    change: function () {
      var files,
          file;

      if (this.support.datauri) {
        files = this.$avatarInput.prop('files'); 
        if (files.length > 0) {
          file = files[0]; 
          if (this.isImageFile(file)) {
            if (this.url) {
              URL.revokeObjectURL(this.url); // Revoke the old one
            }

            this.url = URL.createObjectURL(file);
            this.startCropper();
          }
        }
      } else {
        file = this.$avatarInput.val(); 
        if (this.isImageFile(file)) {
          this.syncUpload();
        }
      }
    },

    submit: function () {
      if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
        return false;
      }

      if (this.support.formData) {
        this.ajaxUpload();
        return false;
      }
    },

    rotate: function (e) {
      var data;

      if (this.active) {
        data = $(e.target).data();

        if (data.method) {
          this.$img.cropper(data.method, data.option);
        }
      }
    },

    isImageFile: function (file) {
      if (file.type) {
        return /^image\/\w+$/.test(file.type);
      } else {
        return /\.(jpg|jpeg|png|gif)$/.test(file);
      }
    },
   
    startCropper: function () {
      var _this = this;

      if (this.active) { 
        this.$img.cropper('replace', this.url);
      } else {
        this.$img = $('<img src="' + this.url + '">');
        this.$avatarWrapper.empty().html(this.$img); 
	    var aspectRatio =  this.$width / this.$height;
        this.$img.cropper({
          aspectRatio: aspectRatio,
		  dragMode: 'move',
          preview: this.$avatarPreview.selector,
          strict: false, 
		  cropBoxResizable:1,
		  zoomable:1,
		  zoomOnWheel:0,
          crop: function (data) {
            var json = [
				'{"x":' + Math.round(data.x),
                  '"y":' + Math.round(data.y),
				  '"image_height":' + _this.$height,
				  '"image_width":' + _this.$width,   
                  '"height":' + Math.round(data.height),
                  '"width":' + Math.round(data.width),
                  '"rotate":' + data.rotate + '}'
                ].join();

            _this.$avatarData.val(json);
          }
        });  
        this.active = true;
      }
	  
	    setTimeout(function(){  
		  	  var imageinfo = _this.$img.cropper('getImageData');
			  var naturalWidth = imageinfo.naturalWidth;
			  var naturalHeight = imageinfo.naturalHeight;
			  var result = _this.$img.cropper('getData'); 
			  var _left = (naturalWidth - _this.$width)/2;
			  var _top = (naturalHeight - _this.$height)/2;
			  if (_left < 0 ) _left = 0;
			  if (_top < 0 ) _top = 0;
		  	  result.x = _left;
		  	  result.y = _top; 
		  	  result.width = _this.$width;
		  	  result.height = _this.$height;  
		  	  _this.$img.cropper('setData',result); 
	  	},500);
	
    },

    stopCropper: function () {
      if (this.active) {
        this.$img.cropper('destroy');
        this.$img.remove();
        this.active = false;
      }
    },

    ajaxUpload: function () {
      var url = this.$avatarForm.attr('action'),
          data = new FormData(this.$avatarForm[0]),
          _this = this; 
		   
		  
      $.ajax(url, {
        type: 'post',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,

        beforeSend: function () {
          _this.submitStart();
        },

        success: function (data) { 
          _this.submitDone(data);
        },

        error: function (XMLHttpRequest, textStatus, errorThrown) { 
		  _this.submitFail("您上传的文件太大，不能超过5M，还可能您的网络已经异常，请检查网络是否畅通!");
          //_this.submitFail(textStatus || errorThrown);
        },

        complete: function () {
          _this.submitEnd();
        }
      });
    },

    syncUpload: function () {
      this.$avatarSave.click();
    },

    submitStart: function () {
        this.$loading.fadeIn();
    },

    submitDone: function (data) {
      console.log(data);

      if ($.isPlainObject(data) && data.state === 200) {
        if (data.result && data.result != "/") {
          this.url = data.result;

          if (this.support.datauri || this.uploaded) {
            this.uploaded = false;
            this.cropDone();
          } else {
            this.uploaded = true;
            this.$avatarSrc.val(this.url);
            this.startCropper();
          }

          this.$avatarInput.val('');
        } else if (data.message) {
          this.alert(data.message);
        }
      } else {
        this.alert('服务器错误的响应！');
      }
    },

    submitFail: function (msg) {
      this.alert(msg);
    },

    submitEnd: function () {
       this.$loading.fadeOut();
    },
	
    btnclose: function () {
		 this.$avatar_close_btn.css("display","none");
		 this.$avatar_input.val("")
		 this.$avatar.attr('src', "/Public/images/uploadimg.png");
	},
    cropDone: function () {
      this.$avatarForm.get(0).reset();
      this.$avatar.attr('src', this.url);
      this.stopCropper();
	  
	  this.$avatar_input.val(this.url)
	  this.$avatar_close_btn.css("display","block");
	  this.$avatar_input.trigger("validate"); 
      BJUI.dialog("closeCurrent");
    },

    alert: function (msg) {
      var $alert = [
            '<div class="alert alert-danger avater-alert">',
              '<button type="button" class="close" data-dismiss="alert">&times;</button>',
              msg,
            '</div>'
          ].join('');

      this.$avatarUpload.after($alert);
    }
  }; 
  $.InitCropAvatar = function (module,fieldname,width,height) 
  {
     return new CropAvatar(module,fieldname,width,height);
  }
}(jQuery));
