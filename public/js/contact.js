let j = jQuery.noConflict();
    var contactForm = document.querySelector('.contact-form');
    contactForm.onsubmit = document.querySelector('button[name="sendMail"]').addEventListener('click', function(event){
    event.preventDefault();
    const ContactFormData = new FormData(document.querySelector('#formFields'));
    

      j.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
            }
        });

      j.ajax({
            type: "POST",
            dataType:'json',
            url : "send-mail",
            data:ContactFormData,
            contentType: false,
            processData: false,
            beforeSend:function(){
                j('#sendEmailBtn').attr('disabled');
                j('#sendEmailBtn').html('Sending Message...');
            },
            success : function (res) {
              // console.log(JSON.stringify(res));

              j('#sendEmailBtn').removeAttr('disabled');
              j('#sendEmailBtn').html('Send Message');

              if(res.success)
              {
                document.querySelector('#formFields').reset();
                swal({
                  text: res.success,
                  icon: "success",
                  button: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "standard-color",
                  closeModal: true,
                  },
                });
              }


              if(res.name)
              {
                const nameErrorContainer=document.querySelector('#nameError');
                nameErrorContainer.style.display='block';
                nameErrorContainer.innerHTML = res.name;
              }
              else
              {
                const nameErrorContainer=document.querySelector('#nameError');
                nameErrorContainer.style.display='none';
                nameErrorContainer.innerHTML = '';
              }


              if(res.email)
              {
                const emailErrorContainer=document.querySelector('#emailError');
                emailErrorContainer.style.display='block';
                emailErrorContainer.innerHTML = res.email;
              }
              else
              {
                const emailErrorContainer=document.querySelector('#emailError');
                emailErrorContainer.style.display='none';
                emailErrorContainer.innerHTML = '';
              }


              if(res.message)
              {
                const msgErrorContainer=document.querySelector('#msgError');
                msgErrorContainer.style.display='block';
                msgErrorContainer.innerHTML = res.message;
              }
              else
              {
                const msgErrorContainer=document.querySelector('#msgError');
                msgErrorContainer.style.display='none';
                msgErrorContainer.innerHTML = "";
              }
            }
        });
    

  });

  
