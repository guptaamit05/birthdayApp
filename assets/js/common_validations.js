
  /* validate Function Description 
    *   * This function is to validate inputs for specified validations
    *   * it accepts an array of objects  
    *   * this object contains various properties that are required to 
    *       identify the input(name), 
    *       title, 
    *       index (for multiple records),
    *       validations(minimum one validation), and 
    *       corresponding custom messages for validations (optional) 
    *   * REQUIREMENTS:
    *       inputs must have name attribute
    *       there must be a span with class error-<name attribute>
    *       in case of multiple records there must be a data-index attribute with numeric value
    *   * Usage:
    *       we can pass one or more than one objects depending on our requirement
    *       eg: 
    *         if we need to validate on click of submit btn then we can pass objects for inputs we need to validate
    *         OR
    *         if we need to check after every keypress, then we can pass object for that input only in keypress event 
    * 
    *       Similarly we can call this function according to our requirements
    * 
  */
 var validate = (options) => {
  // console.clear();

  validationStatus = true;

  $.each(options, function(index, value) {
    options[index].errorMessage = []; // to store validation failed messages if validation failed
    if(typeof value.index != 'undefined') {
      inputIndex = value.index;
      inputElement = $('[name="' + value.name + '[]"][data-index="'+ inputIndex +'"]');  // Current value of input
      errorSpan = $('.error-' + value.name + '[data-index="'+ inputIndex +'"]');
    }else{
      inputElement = $('[name="' + value.name + '"]');  // Current value of input
      errorSpan = $('.error-' + value.name);
    }
    title = value.title;  // this will be the name shown in message
    if(typeof value.currentValue != 'undefined' ) {
      if(value.currentValue) {
        inputValue = value.currentValue;  // Current value of input
      }else{
        inputValue = null;
      }
    }else{
      if(inputElement.val() != null && inputElement.val().constructor !== Array){
        inputValue = inputElement.val().trim();  // Current value of input
      }else{
        if(inputElement.val() != null) {
          inputValue = inputElement.val().length;  // Current value of input
        }else{
          inputValue = '';  // Current value of input
        }
      }
    }

    errorSpan.html(''); // clear previous messages if present

    $.each(value.validations, function(index2, value2) {  // itterate over the validations need to be check
      checkCondition = true;
      // check for conditions before validation
      if( typeof value.checkCondition != 'undefined') {
        $.each(value.checkCondition, function(index3, value3) {
          switch(value3) {
            case 'checked':
              if(!$('[name="'+ index3 +'"]').is(':checked')) {
                checkCondition = false;
              }
          }
        });
      }

      if(!checkCondition){
        return;
      }

      switch (index2) { // switch according to the type of validation
        
        case 'required':  // if required validation is specified
          if (value2 && !inputValue && inputValue !== 0 && inputValue !== '0') {  // if required is true and value of input is blank
            if( typeof value.message != 'undefined' && typeof value.message.required != 'undefined'){ // check if there is a custom message
              options[index].errorMessage.push("* " + value.message.required);  // store custom message in errorMessage property
            }else{
              options[index].errorMessage.push("* " + title + " cannot be empty."); // this will be the default message of custom not present
            }
            validationStatus = false;
          }
          break;
        
        case 'minlength': // if minlength must be validated
          if (inputValue && inputValue.length < value2 ) {
            if( typeof value.message != 'undefined' && typeof value.message.minlength != 'undefined'){
              options[index].errorMessage.push("* " + value.message.minlength);
            }else{
              options[index].errorMessage.push("* " + title + " cannot be less than " + value2 + " characters.");
            }
            validationStatus = false;
          }
          break;
        case 'maxlength': // if maxlength must be validated
          if (inputValue && inputValue.length > value2) {
            $(inputElement).val(inputValue.substring(0,value2));
            if( typeof value.message != 'undefined' && typeof value.message.maxlength != 'undefined' ){
              options[index].errorMessage.push("* " + value.message.maxlength);
            }else{
              options[index].errorMessage.push("* " + title + " cannot be more than " + value2 + " characters.");
            }
            validationStatus = false;
          }
          break;
        case 'numeric': // if input value must be numbers only
          if(value2 && inputValue && !$.isNumeric(inputValue)) {
            inputElement.val(inputElement.val().replace(/[^\d]/, ""));
          }
          break;
        case 'minValue': // if minValue must be greater than value2
          if (inputValue && inputValue < value2 ) {
            if( typeof value.message != 'undefined' && typeof value.message.minValue != 'undefined'){
              options[index].errorMessage.push("* " + value.message.minValue);
            }else{
              options[index].errorMessage.push("* " + title + " should be greate than $" + value2 + ".");
            }
            validationStatus = false;
          }
          break;
        case 'paste':
          if (!value2 && value.event.type == 'paste') {
            value.event.preventDefault();
          }
          break;
        case 'phone': // check pattern (XXX-XXX-XXXX)
          if(value2){
            var r = /(\D+)/g,
            npa = '',
            nxx = '',
            last4 = '';
            phoneValue = inputElement.val().replace(r, '');
            npa = phoneValue.substr(0, 3);
            nxx = phoneValue.substr(3, 3);
            last4 = phoneValue.substr(6, 4);
            // f.value = npa + '-' + nxx + '-' + last4;

            if (!npa && !nxx && !last4) {
              phoneValue = '';
            } else if (npa && !nxx && !last4) {
              phoneValue = npa;
            } else if (npa && nxx && !last4) {
              phoneValue = npa + '-' + nxx;
            } else if (npa && nxx && last4) {
              phoneValue = npa + '-' + nxx + '-' + last4;
            }
            inputElement.val(phoneValue);
          }
          break;
        case 'email':
          pattern = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if(!pattern.test(inputValue)) {
            if( typeof value.message != 'undefined' && typeof value.message.email != 'undefined' ){
              options[index].errorMessage.push("* " + value.message.email);
            }else{
              options[index].errorMessage.push("* " + title + " must be a valid email.");
            }
            validationStatus = false;
          }
          break;
        case 'unique':
          if (value.event.type == 'blur') {
            $.ajax({
              url: value2.url,
              type: 'POST',
              async: false,
              data: value2.data,
              success: function(response) {
                if (!response.trim()) {
                  if( typeof value.message != 'undefined' && typeof value.message.unique != 'undefined' ){
                    options[index].errorMessage.push("* " + value.message.unique);
                  }else{
                    options[index].errorMessage.push("* " + title + " already exist.");
                  }
                  validationStatus = false;
                }
              }
            });
          }
          break;
        case 'match':
          if(inputValue != $('[name="'+ value2 +'"]').val()) {
            if( typeof value.message != 'undefined' && typeof value.message.match != 'undefined' ){
              options[index].errorMessage.push("* " + value.message.match);
            }else{
              options[index].errorMessage.push("* " + title + " must match "+ value2 +".");
            }
            validationStatus = false;
          }
          break;
        case 'date':
          if(inputValue){
            switch(value2.format) {
              case 'mm-dd-yyyy':
                datePattern = /^((0|1)\d{1})-((0|1|2)\d{1})-((19|20)\d{2})/;
                break;
              case 'dd-mm-yyyy':
                datePattern = /^((0|1|2)\d{1})-((0|1)\d{1})-((19|20)\d{2})/;
                break;
              case 'yyyy-mm-dd':
                datePattern = /^((19|20)\d{2})-((0|1)\d{1})-((0|1|2)\d{1})/;
                break;
              default:
                console.log("Pattern not recognized");
                validationStatus = false;
                return;
                break;
            }
            if(!datePattern.test(inputValue)) {
              if( typeof value.message != 'undefined' && typeof value.message.match != 'undefined' ){
                options[index].errorMessage.push("* " + value.message.match);
              }else{
                options[index].errorMessage.push("* " + title + " format must be "+ value2.format +".");
              }
              validationStatus = false;
            }
          }
          break;
        case 'fileType':
          if(inputValue){
            extension = inputValue.substr( (inputValue.lastIndexOf('.') +1) );
            if ($.inArray(extension, value2.allowed) == -1){
              if( typeof value.message != 'undefined' && typeof value.message.fileType != 'undefined' ){
                options[index].errorMessage.push("* " + value.message.fileType);
              }else{
                options[index].errorMessage.push("* Only "+ value2.allowed.toString() +" are allowed.");
              }
              validationStatus = false;
            }
          }
          break;
        case 'fileSize':
          console.log(inputElement);
          if(inputValue){
            let fileSize = inputElement[0].files[0].size;
            console.log(fileSize);
            if(fileSize > (value2 * 1024 * 1024)) {
              if( typeof value.message != 'undefined' && typeof value.message.fileType != 'undefined' ){
                options[index].errorMessage.push("* " + value.message.fileType);
              }else{
                options[index].errorMessage.push("* Maximum file size cannot exceed "+ value2 +"MB.");
              }
              $(inputElement).val(null);
              validationStatus = false;
            }
          }
          break;
      }
    });
  });

  $.each(options, function(index, value) {

    if(typeof value.index != 'undefined') {
      inputIndex = value.index;
      errorSpan = $('.error-' + value.name + '[data-index="'+ inputIndex +'"]');
    }else{
      errorSpan = $('.error-' + value.name);
    }

    if (options[index].errorMessage) {
      $.each(options[index].errorMessage, function(index2, value2) {
        if (!errorSpan.html()) {
          errorSpan.append(value2);
        } else {
          errorSpan.append('<br>' + value2);
        }
      });
      errorSpan.show();
    }
  });

  return validationStatus;
}

/* sample validation for use on view page
  
  field = {
    organization_name: {
      name: 'organization_name',
      title: "Organization Name",
      validations: {
       required : true,
      }
    },
    organization_address: {
      name: 'organization_address',
      title: "Address",
      validations: {
       required : true,
      }
    },
    organization_country: {
      name: 'organization_country',
      title: "Country",
      validations: {
      required  : true,
      },
      message: {
      required  : "Country is required.",
      }
    },
    organization_state: {
      name: 'organization_state',
      title: "State",
      validations: {
       required : true,
      },
      message: {
       required : "State is required.",
      }
    },
    organization_city: {
      name: 'organization_city',
      title: "City",
      validations: {
      required  : true,
      },
      message: {
      required  : "City is required.",
      }
    },
    organization_zip: {
      name: 'organization_zip',
      title: "Zip",
      event: {},
      validations: {
      required  : true,
        numeric: true,
        paste: false,
        minlength: 5,
        maxlength: 7
      },
    },
    organization_phone1: {
      name: 'organization_phone1',
      title: "Phone1",
      event: {},
      validations: {
      required  : true,
        phone: true,
        paste: false,
        minlength: 12,
        maxlength: 12,
      },
    },
    organization_phone2: {
      name: 'organization_phone2',
      title: "Phone2",
      event: {},
      validations: {
        phone: true,
        paste: false,
        minlength: 12,
        maxlength: 12,
      },
    },
    organization_alert_email: {
      name: 'organization_alert_email',
      title: "Email",
      event: {},
      validations: {
      required : true,
        email: true,
                 
          unique: {
              url: '<?php echo base_url('admin/checkUnique') ?>',
              data: { value: '', key1: 'org', key2: 'org_alert_email' },
            }
       }
    },  
  };
*/
