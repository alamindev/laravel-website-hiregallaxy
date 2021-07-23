<style>
    label {
        font-weight: bold;
    }

    .form-group {
        margin-top: -14px;
    }

    .mce-branding-powered-by {
        display: none;
    }

    .mce-statusbar .mce-container-body {
        display: none;
    }

    .mce-panel {
        border: 0 solid #9e9e9e30;
        border-bottom: 0px !important;
    }

    .mce-container,
    .mce-container *,
    .mce-widget,
    .mce-widget *,
    .mce-reset {
        border-right: 1px solid transparent;
    }
</style>
<script>

      tinymce.init({



        selector: '.template',



        plugins: "{{ config('constants.tiny_plugins') }}",



        toolbar: "{{ config('constants.tiny_toolbar') }}",



        contextmenu: "{{ config('constants.tiny_contextmenu') }}",



        autoresize_bottom_margin: 0,



        image_advtab: true,



        menubar: false,



        });


$(".saveTemplate").click(function(e) {
    let summery_error = $(".job-summery-error");
    let responsibilities_error = $(".responsibilities-error");
    let qualification_error = $(".qualification-error");
    let certification_error = $(".certification-error");
    let experience_error = $(".experience-error");
    let about_error = $(".about-company-error");
    summery_error.empty();
    responsibilities_error.empty();
    qualification_error.empty();
    certification_error.empty();
    experience_error.empty();
    about_error.empty();

    for (i = 0; i < tinyMCE.editors.length; i++) {
        var content = tinyMCE.editors[i].getContent();
        if (tinyMCE.editors[i].id == "job_summery") {
            if (content.length > 4 && content.length <= 11) {
                e.preventDefault();
                $(".textarea .filled").hide();
                $('<span class="text-danger pl-2"></span>')
                    .html("Length must be greater than 5 characters")
                    .appendTo(summery_error);
            } else {
                summery_error.empty();
            }
        } else if (tinyMCE.editors[i].id == "responsibilities") {
            if (content.length > 4 && content.length <= 11) {
                e.preventDefault();
                $(".textarea .filled").hide();
                $('<span class="text-danger pl-2"></span>')
                    .html("Length must be greater than 5 characters")
                    .appendTo(responsibilities_error);
            } else {
                responsibilities_error.empty();
            }
        } else if (tinyMCE.editors[i].id == "qualification") {
            if (content.length > 4 && content.length <= 11) {
                e.preventDefault();
                $(".textarea .filled").hide();
                $('<span class="text-danger pl-2"></span>')
                    .html("Length must be greater than 5 characters")
                    .appendTo(qualification_error);
            } else {
                qualification_error.empty();
            }
        } else if (tinyMCE.editors[i].id == "certification") {
            if (content.length > 4 && content.length <= 11) {
                e.preventDefault();
                $(".textarea .filled").hide();
                $('<span class="text-danger pl-2"></span>')
                    .html("Length must be greater than 5 characters")
                    .appendTo(certification_error);
            } else {
                certification_error.empty();
            }
        } else if (tinyMCE.editors[i].id == "experience") {
            if (content.length > 4 && content.length <= 11) {
                e.preventDefault();
                $(".textarea .filled").hide();
                $('<span class="text-danger pl-2"></span>')
                    .html("Length must be greater than 5 characters")
                    .appendTo(experience_error);
            } else {
                experience_error.empty();
            }
        } else if (tinyMCE.editors[i].id == "about_company") {
            if (content.length > 4 && content.length <= 11) {
                e.preventDefault();
                $(".textarea .filled").hide();
                $('<span class="text-danger pl-2"></span>')
                    .html("Length must be greater than 5 characters")
                    .appendTo(about_error);
            } else {
                about_error.empty();
            }
        }
    }
});
</script>
