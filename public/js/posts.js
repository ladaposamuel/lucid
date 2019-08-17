let j = jQuery.noConflict();
  var toolbarOptions = [
    ['bold', 'italic'],
    ['blockquote'],
    [{
      'list': 'ordered'
    }, {
      'list': 'bullet'
    }],
    [{
      'header': [1, 2, 3, 4, 5, 6, false]
    }],
    ['link', 'image'],
    ['clean']
  ];

  var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
      toolbar: toolbarOptions
    },
    placeholder: 'Compose an epic...'
  });
  j(".ql-toolbar").css("display", "block");

  var form = document.querySelector('.timeline-editor');

  // handle creating new post
  form.onsubmit = newPostSubmitHandler;

  // handle saving draft
  document.querySelector('input[value="Save Draft"]').addEventListener('click', newPostSubmitHandler);

  function newPostSubmitHandler(event) {
    event.preventDefault();
    let currentPage = window.localStorage.getItem('page');
    const formData = new FormData(document.querySelector('#editor-form'));
    const blogBody = document.querySelector('.ql-editor').innerHTML;




    const title = document.querySelector("#new-post-title").value;


    // convert to markdown
    const turndownService = new TurndownService({
      codeBlockStyle: 'fenced'
    });
    const gfm = turndownPluginGfm.gfm;
    turndownService.use(gfm);
    let markdown = turndownService.turndown(blogBody);
    if (markdown !== "" && title !== "") {
      formData.set('title', title);
      // check if the form is being submitted
      // which would mean a new post is being created rather than saving a draft
      const newPostIsBeingCreated = event.target instanceof HTMLFormElement;

      // get all imageURIs in the document
      let imageURIs = markdown.match(/\!\[\]\(data:image\/\w+;base64,[^)]*\)/g);
      // are there images in the blog post?
      if (imageURIs) {
        // remove duplicates
        imageURIs = imageURIs.reduce((acc, curVal) => {
          if (!acc.includes(curVal)) acc.push(curVal);
          return acc;
        }, []);



        imageURIs.forEach(imageURI => {
          const [, fullURI, ext, uriData] = imageURI.match(/\!\[\]\((data:image\/(\w+);base64,([^)]*))\)/);
          const id = Math.random().toString(36).substr(2, 10);
          const newImgName = `img-${id}.${ext}`;
          const username = j('meta[name="username"]').attr('content');


          // replace the image URI everywhere it occurs in the markdown
          let stillMatching = true;
          while (stillMatching) {
            if (markdown.includes(fullURI)) {
              markdown = markdown.replace(fullURI, `/storage/${username}/images/${newImgName}`);
            } else {
              stillMatching = false;
            }
          }

          // add this info to the form data being sent to the backend
          formData.set(newImgName, uriData);
        });

      }


      formData.set('postVal', markdown);


      

      //send the form data

      j.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
          }
      });

      j.ajax({
            type: "POST",
            dataType:'json',
            url : "publish",
            data:formData,
            contentType: false,
            processData: false,
            success : function (res) {
              //console.log(JSON.stringify(res));

                if (res.error == false && res.action == 'publish') {
                  window.localStorage.setItem('publish', 'success');
                  window.location = '/'+j('meta[name="username"]').attr('content')+'/posts';

                } else if (res.error == false && res.action == 'savedToDrafts') {
                  window.localStorage.setItem('savedToDrafts', 'success');
                  window.location = '/'+j('meta[name="username"]').attr('content')+'/posts';
                }
            }
        });

    } else {
      swal({
        text: "Sorry,both fields are required!",
        icon: "error",
        button: {
          text: "OK",
          value: true,
          visible: true,
          className: "standard-color",
          closeModal: true,
      },
      });
    }
  }

  j(document).ready(function() {
    const published = window.localStorage.getItem('publish');
    const savedToDrafts = window.localStorage.getItem('savedToDrafts');
    if (published == 'success') {
      window.localStorage.removeItem('publish');
      swal({
        text: "Your post was successfully created!",
        icon: "success",
        button: {
          text: "OK",
          value: true,
          visible: true,
          className: "standard-color",
          closeModal: true,
      },
      });
    } else if (savedToDrafts == 'success') {
      window.localStorage.removeItem('savedToDrafts');
      swal({
        text: "Your post was successfully created and saved to drafts!",
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

    j('#tags').on('tokenfield:createdtoken', function(e) {
    // .. do stuff here
    j(".token").addClass("standardColor");
  })
  .tokenfield({
      autocomplete:{
        source:[
          'Politics',
          'Sports',
          'Health',
          'Technology',
          'Music',
          'News-Lifestyle',
          'Movies',
          'Fitness'
        ],
        delay:100,
        
      },
      showAutocompleteOnFocus: true,
      createTokensOnBlur: true,
    });


  });