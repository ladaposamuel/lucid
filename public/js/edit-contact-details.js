// const j = jQuery.noConflict();

let  editContactForm= document.querySelector('.editContactForm');
let  editBtn = document.querySelector('button[name="editContactDetails"]');
if (editBtn !=null){
  editContactForm.onsubmit = editBtn.addEventListener('click',function (e){
    e.preventDefault();

    const formData = new FormData(document.querySelector('#formFields'));

    j.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
        }
    });

    j.ajax({
        url:'update-contact-details',
        type:'POST',
        dataType:'json',
        data:formData,
        contentType:false,
        processData:false,
        beforeSend:function(){
            j('#saveBtn').attr('disabled');
            j('#saveBtn').html('Saving...');
        },
        success:function (res){
            console.log(JSON.stringify(res));
            j('#saveBtn').removeAttr('disabled');
            j('#saveBtn').html('Save');

            if(res.success)
              {
                
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

    })

    
  })

}
  