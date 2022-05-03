import Vue from 'vue'
import Card from './Card.vue'
import Child from './Child.vue'
import Button from './Button.vue'
import Checkbox from './Checkbox.vue'
import { 
  HasError,
  AlertError,
  AlertErrors, 
  AlertSuccess
} from 'vform'

// Components that are registered globaly.
[
  Card,
  Child,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertErrors,
  AlertSuccess
].forEach(Component => {
  Vue.component(Component.name, Component)
})
