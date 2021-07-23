<style scoped>
.form-control, div{
  text-align: left!important;
}
</style>

<template>
  <span>

    <a href="#addReviewModal" class="btn btn-outline-yellow" data-toggle="modal" title="Submit Your Review"><i class="fa fa-plus text-white"></i></a>

    <div class="modal animated fadeIn" id="addReviewModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title text-theme font22 bold">Submit Your Review</h4>
            <button type="button" class="close ml-2" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div v-if="!isSubmitted">
              <div v-if="is_company == '1'">
                <div class="row form-group">
                  <div class="col-sm-6">
                    <label for="name">Your Name <span class="required">*</span></label>
                    <input type="text" class="form-control" name="name" v-model="name" id="name" placeholder="Write Your Name" required>
                  </div>
                  <div class="col-sm-6">
                    <label for="position">Your Job Position <span class="required">*</span></label>
                    <input type="text" class="form-control" name="position" v-model="position" id="position" placeholder="Write Your Job Position" required>
                  </div>
                </div>
              </div>
              <div v-else>
                <input type="hidden" class="form-control" name="name" v-model="name" id="name" required>
                <input type="hidden" class="form-control" name="position" v-model="position" id="position" required>
              </div>

              <textarea name="review" v-model="review" cols="30" rows="5" class="form-control" placeholder="Review"></textarea>

              <div class="mt-3">
                <p>
                  <a @click="addReview" class="btn btn-outline-success" style="color: #000"><i class="fa fa-check"></i> Submit Review</a>
                </p>
              </div>
            </div>
            <div v-else>
              <div class="alert alert-success">
                <p class="text-center font30 mb-2">
                  <i class="fa fa-check"></i> Thank You
                </p>
                <p class="text-center">
                  {{ message }}
                </p>
              </div>
            </div>

            

          </div>

          

        </div>
      </div>
    </div>

  </span>
</template>

<script>
  import {bus} from '../app';

  export default {
    props: {
      url: {
        type: String,
        required: true
      },
      api_token: {
        type: String,
        required: true
      },
      is_company: {
        type: String,
        required: true
      }
    },
    mounted() {
      var app = this;
    },
    data(){
      return {
        isSubmitted: false,
        review: '',
        name: '',
        position: '',
        message: ''
      }
    },
    methods: {
      addReview(){
        var app = this;
        if (app.is_company == '1') {
          if (app.name.length == 0) {
            alert('Please give your name');
            return false;
          }
          if (app.position.length == 0) {
            alert('Please give your position at company');
            return false;
          }
        }
        if (app.review.length == 0) {
          alert('Please give your review');
          return false;
        }

        if (app.api_token != 0) {
          axios.post(app.url+'/api/reviews/add', {
            api_token: app.api_token,
            review: app.review,
            name: app.name,
            position: app.position,
          })
          .then((response) => {
           new Noty({
            theme: 'sunset',
            type: 'success',
            layout: 'topCenter',
            text: response.data.message,
            timeout: 3000
          }).show();

           if (response.data.status == 'success') {
            app.isSubmitted = true;
            app.message = response.data.message;
            app.name = '';
            app.position = '';
            app.review = '';
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


      }
    }
  }
</script>
