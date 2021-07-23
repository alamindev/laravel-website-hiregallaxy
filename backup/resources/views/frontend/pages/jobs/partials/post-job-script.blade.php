<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<style>
  .cke_editable {
    border: 1px solid #ced4da;
    padding: 10px;
  }

  .cke_editable:focus {
    outline: #607d8b1f auto 1px;
  }

  @if( !App\Models\Setting::first()->enable_job_editing) .cke_inner {
    display: none;
  }

  @endif
</style>
<script>
  CKEDITOR.inline('job_summery');
  CKEDITOR.inline('responsibilities');
  CKEDITOR.inline('qualification');
  CKEDITOR.inline('certification');
  CKEDITOR.inline('experience');
  CKEDITOR.inline('about_company');

  @if(!App\Models\Setting::first()->enable_job_editing)
    var url = "{{ Url('/') }}"+"/api/templates";
      $.get( url )
      .done(function( data ) {
        CKEDITOR.instances['job_summery'].setReadOnly(true);
        CKEDITOR.instances['responsibilities'].setReadOnly(true);
        CKEDITOR.instances['qualification'].setReadOnly(true);
        CKEDITOR.instances['certification'].setReadOnly(true);
        CKEDITOR.instances['experience'].setReadOnly(true);
        CKEDITOR.instances['about_company'].setReadOnly(true);
      });

    @endif

</script>