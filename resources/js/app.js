import './bootstrap';

// Import Vue
import { createApp } from 'vue'

// Import PrimeVue Config
import PrimeVue from 'primevue/config'

// Import PrimeVue Components
import Autocomplete from 'primevue/autocomplete'
import Avatar from 'primevue/avatar'
import Button from 'primevue/button'
import BlockUI from 'primevue/blockui'
import Breadcrumb from 'primevue/breadcrumb'
import Card from 'primevue/card'
import Calendar from 'primevue/calendar'
import Chart from 'primevue/chart'
import Checkbox from 'primevue/checkbox'
import Chip from 'primevue/chip'
import ConfirmDialog from 'primevue/confirmdialog'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import Dialog from 'primevue/dialog'
import Divider from 'primevue/divider'
import DynamicDialog from 'primevue/dynamicdialog'
import Editor from 'primevue/editor'
import FileUpload from 'primevue/fileupload'
import InputText from 'primevue/inputtext'
import InputMask from 'primevue/inputmask'
import InputNumber from 'primevue/inputnumber'
import InputSwitch from 'primevue/inputswitch'
import InputPassword from 'primevue/password'
import Menu from 'primevue/menu'
import Message from 'primevue/message'
import Menubar from 'primevue/menubar'
import Multiselect from 'primevue/multiselect'
import Paginator from 'primevue/paginator'
import ProgressBar from 'primevue/progressbar'
import ProgressSpinner from 'primevue/progressspinner'
import Sidebar from 'primevue/sidebar'
import Select from 'primevue/dropdown'
import Skeleton from 'primevue/skeleton'
import TabMenu from 'primevue/tabmenu'
import TabPanel from 'primevue/tabpanel'
import TabView from 'primevue/tabview'
import Tag from 'primevue/tag'
import TextArea from 'primevue/textarea'
import Toast from 'primevue/toast'
import ToggleButton from 'primevue/togglebutton'
import Toolbar from 'primevue/toolbar'

// PrimeVue Services
import ConfirmationService from 'primevue/confirmationservice'
import DialogService from 'primevue/dialogservice'
import ToastService from 'primevue/toastservice'
import Tooltip from 'primevue/tooltip'

// Import Custom Components
import AppMenuItem from '@/views/components/AppMenuItem.vue'
import UserAvatar from '@/views/components/UserAvatar.vue'

// Router Settings
import router from '@/router'

// State Management
import store from '@/store'

// Custom CSS
import '../sass/app.scss'

// App Component
import App from '@/App.vue'

// Create App
const app = createApp(App)

// Use PrimeVue
app.use(PrimeVue, { ripple: true })

// Use PrimeVue Services
app.use(ConfirmationService)
app.use(ToastService)
app.use(DialogService)

// Use PrimeVue Directives
app.directive('tooltip', Tooltip)

// Use PrimeVue Components Globally
app.component('p-autocomplete', Autocomplete)
app.component('p-avatar', Avatar)
app.component('p-button', Button)
app.component('p-block-ui', BlockUI)
app.component('p-breadcrumb', Breadcrumb)
app.component('p-card', Card)
app.component('p-calendar', Calendar)
app.component('p-chart', Chart)
app.component('p-checkbox', Checkbox)
app.component('p-chip', Chip)
app.component('p-confirm-dialog', ConfirmDialog)
app.component('p-column', Column)
app.component('p-data-table', DataTable)
app.component('p-dialog', Dialog)
app.component('p-divider', Divider)
app.component('p-dynamic-dialog', DynamicDialog)
app.component('p-editor', Editor)
app.component('p-file-upload', FileUpload)
app.component('p-input-text', InputText)
app.component('p-input-mask', InputMask)
app.component('p-input-number', InputNumber)
app.component('p-input-password', InputPassword)
app.component('p-menu', Menu)
app.component('p-message', Message)
app.component('p-menubar', Menubar)
app.component('p-multiselect', Multiselect)
app.component('p-paginator', Paginator)
app.component('p-progress-bar', ProgressBar)
app.component('p-progress-spinner', ProgressSpinner)
app.component('p-select', Select)
app.component('p-sidebar', Sidebar)
app.component('p-skeleton', Skeleton)
app.component('p-switch', InputSwitch)
app.component('p-tab-menu', TabMenu)
app.component('p-tab-panel', TabPanel)
app.component('p-tab-view', TabView)
app.component('p-tag', Tag)
app.component('p-textarea', TextArea)
app.component('p-toast', Toast)
app.component('p-toggle-button', ToggleButton)
app.component('p-toolbar', Toolbar)

// Use Custom Components Globally
app.component('app-menu-item', AppMenuItem)
app.component('user-avatar', UserAvatar)

// Use Router and Store and Mount App
app.use(router)
  .use(store)
  .mount('#app')
