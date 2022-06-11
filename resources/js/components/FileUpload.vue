<template>
    <div class="mb-3 row">
      <label class="col-md-4 col-form-label text-md-right">{{ label }}<span v-if="need" class="col-form-mark">必須</span></label>
      <div class="col-md-8">
        <div :class="{ 'is-invalid': form.errors.has(name) }" class="mt-2">
          <input :disabled="disabled" ref="file" type="file" v-on:change="onFileChange" :name="name" accept="image/jpg, image/jpeg, image/png, .heic, .heif" class="form-control-file">
          <img :src="image" class="img-responsive mt-2" v-if="image">
        </div>
        <has-error :form="form" :field="name" />
      </div>
    </div>
</template>
<style scoped>
  img{
      max-height: 36px;
  }
</style>
<script>
    export default{
        props: [ 'form', 'name', 'label', 'disabled', 'need' ],
        created() {
          var image = this.form[this.name]
          if(image) {
            this.$refs.file = image
            this.image = image
          }
        },
        data(){
            return {
                image: ''
            }
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                let file = files[0]
                if(file['size'] > 5242880) {
                  alert('5MB以下の画像をアップロードしてください。')
                  this.image = ''
                  e.target.value = null
                  return
                }
                if(!this.validFileType(file)) {
                  alert('*.jpg, *.png, *.jpeg, *.heic, *.heif形式の画像をアップロードしてください。')
                  this.image = ''
                  e.target.value = null
                  return
                }
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                    vm.$emit('update', vm.name, vm.image)
                };
                reader.readAsDataURL(file);
            },
            validFileType(file) {
              const fileTypes = [
                "image/jpeg",
                "image/png",
                "image/jpg",
                ".heic", 
                ".heif"
              ];
              return fileTypes.includes(file.type);
            }
        }
    }
</script>