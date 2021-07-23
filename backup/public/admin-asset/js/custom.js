/** @type {TinyMCE} tinyMCE initialization for whole admin panel */
vm = this;
// tinymce.init({
//     selector: ".tinymce",
//     // plugins: 'paste print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
//     plugins: "print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern",
//     contextmenu: "copy paste",
//     toolbar: "bold italic hr forecolor backcolor autolink  | link  image | alignleft aligncenter alignright | numlist bullist | preview",
//     image_advtab: true,
//     menubar: false,
//     setup: function(editor) {
//         editor.on("keyup", function(e) {
//             vm.model = editor.getContent();
//         });
//     }
// });

vm = this;
tinymce.init({
    selector: ".tinyadvance",
    plugins: "codesample code print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern",
    toolbar: "bold italic hr forecolor backcolor | codesample code autolink  | link  image | alignleft aligncenter alignright | numlist bullist | preview",
    image_advtab: true,
    menubar: false,
    setup: function(editor) {
        editor.on("keyup", function(e) {
            vm.model = editor.getContent();
        });
    }
});