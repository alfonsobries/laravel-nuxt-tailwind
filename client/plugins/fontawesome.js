import Vue from 'vue'
import { library, config } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// import { } from '@fortawesome/fontawesome-free-regular'

import {
  faUser, faLock, faSignOutAlt, faCog
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub
} from '@fortawesome/free-brands-svg-icons'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub
)

config.autoAddCss = false

Vue.component('fa', FontAwesomeIcon)
