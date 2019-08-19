let j = jQuery.noConflict();
  j(document).ready(function (){

    ////render selected image to the profile image tag
    j("#profileimage").on('change',function(){
      const file = $(this)[0].files;

      if (file.length == 1 ){

         const reader = new FileReader();
         const imgTag = document.getElementById('imgtag');
         reader.onload = function(event){
           imgTag.src=event.target.result;
         }

         reader.readAsDataURL(file[0])
      }

    })

    hereLinkOnSettingsPage = document.querySelector('#onSettingsPage');
    if(hereLinkOnSettingsPage !=null){
      hereLinkOnSettingsPage.style.color="#a9a9a9";
      hereLinkOnSettingsPage.removeAttribute('href');
    }
    

    document.querySelector('button[name="update"]').addEventListener('click',function (event){
      event.preventDefault();
      const formData = new FormData(document.querySelector('#settingsForm'));


      j.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
            }
        });

      j.ajax({
            type: "POST",
            dataType:'json',
            url : "save_settings",
            data:formData,
            contentType: false,
            processData: false,
            beforeSend:function(){
              document.querySelector('#preloader').setAttribute('class','preloader-active');
            },
            success : function (response) {
              //  console.log(JSON.stringify(response));
               document.querySelector('#preloader').removeAttribute('class');
                if (response.success) {
                    
                    swal({
                      text: response.success,
                      icon: "success",
                      button: {
                      text: "OK",
                      value: true,
                      visible: true,
                      className: "standard-color",
                      closeModal: true,
                      },
                    })

                    if(response.img_path){
                       document.querySelector('#user-avatar').src = response.img_path;
                    }
                    document.querySelector('#user-name').innerHTML = formData.get('name');
                    if(formData.get('bio') !==""){
                       document.querySelector('#user-bio').innerHTML = formData.get('bio');
                       document.querySelector('#user-bio').style.color = "#000";

                    }else {
                      document.querySelector('#user-bio').innerHTML = 'You haven\'t set up a short bio about yourself, do that here';
                      document.querySelector('#user-bio').style.color = "#a9a9a9";
                    }

                    if(response.renamedUserContentFolderName){
                       changeHrefs = document.querySelectorAll('.changeHref');
                       changeHrefs.forEach(href=>{
                        urlArray = href.getAttribute('href').split("\/");
                        url = '';
                        if(urlArray.length == 3){
                          url = urlArray.pop();
                        }
                        href.setAttribute('href','/'+response.renamedUserContentFolderName+'/'+url)
                       })
                       window.history.pushState(null,null, '/'+response.renamedUserContentFolderName+'/settings')
                    }
                  
                }

                const name = document.querySelector('#fullname');
                const email = document.querySelector('#emailError');
                const img = document.querySelector('#imgError');
                const username = document.querySelector("#usernameError");
                if (response.name){
                    name.style.display="block"
                    name.innerHTML = response.name
                }else {
                    name.style.display="none"
                    name.innerHTML = ''
                }

                if (response.email){
                    email.style.display="block"
                    email.innerHTML = response.email
                }else {
                    email.style.display="none"
                    email.innerHTML = ''
                }

                if (response.profileimage){
                    img.style.display="block"
                    img.innerHTML = response.profileimage
                }else {
                    img.style.display="none"
                    img.innerHTML = ''
                }

                if (response.username){
                    username.style.display="block"
                    username.innerHTML = response.username
                }else {
                    username.style.display="none"
                    username.innerHTML = ''
                }
              
            },
            error:function (){
              document.querySelector('#preloader').removeAttribute('class');
            }
        });

      

    })

  })