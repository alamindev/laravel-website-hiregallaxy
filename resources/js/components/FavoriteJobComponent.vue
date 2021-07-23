<template>
    <span>

        <a @click="addToFavorite()" class="btn btn-outline-gray favorite-btn ml-2" v-if="!isFavorite" title='Click to add this to favorite list'>
            <i class="fa fa-heart-o"></i>
        </a>
        <a @click="addToFavorite()" class="btn btn-outline-gray favorite-btn" v-else title='Click to remove this from favorite list' style="color: white !important;background: red !important;">
            <i class="fa fa-heart-o"></i>
        </a>
    </span>
</template>

<script>
    import {bus} from '../app';

    export default {
        props: {
            id: {
              type: String,
              required: true
          },
          url: {
              type: String,
              required: true
          },
          api_token: {
              type: String,
              required: true
          }
      },
      mounted() {
        var app = this;
        app.checkFavorite();
    },
    data(){
        return {
            isFavorite: false
        }
    },
    methods: {
        addToFavorite(){
          var app = this;
          if (app.api_token != 0) {
            axios.post(app.url+'/api/jobs/favorite', {
                job_id: app.id,
                api_token: app.api_token,
            })
              .then((response) => {
               new Noty({
                theme: 'sunset',
                type: 'success',
                layout: 'topCenter',
                text: response.data.message,
                timeout: 3000
            }).show();
               bus.$emit("totalFavorite", response.data.totalFavorite);
               app.checkFavorite();
               // If Windows is in the favorite Page, then reload the page
               // if () {}
               var windows_url = window.location.href;
               if (windows_url == app.url+'/candidates/favorite-jobs' || windows_url == app.url+'/employers/favorite-jobs') {
                window.setTimeout(function(){
                    window.location.reload();
                }, 3500);
               }
           })
              .catch((e) => {
                console.log(e);
            })
          }else{
            new Noty({
                theme: 'sunset',
                type: 'error',
                layout: 'topCenter',
                text: 'Please login to add job to favorite list !!',
                timeout: 3000
            }).show();
          }
      },
      checkFavorite(){
        var app = this;
        if (app.api_token != 0) {
            axios.get(app.url+'/api/jobs/check-favorite/'+app.id+'/'+app.api_token)
            .then((response) => {
               if (response.data.status == 'success') {
                app.isFavorite = true;
            }else{
                app.isFavorite = false;
            }
        })
            .catch((e) => {
                console.log(e);
            });
        }
    }
}
}
</script>
