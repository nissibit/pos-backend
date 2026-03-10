
import Alpine from 'alpinejs';
import { persist } from '@alpinejs/persist';
import Swal from 'sweetalert2';
import { createApp } from "vue"


window.Alpine = Alpine
window.Swal = Swal;

Alpine.plugin(persist)

Alpine.start();

// Vuew JS
const app = createApp({})

// Auto registrar componentes
const modules = import.meta.glob("./components/**/*.vue", { eager: true })

Object.entries(modules).forEach(([path, module]) => {

    const componentName = path
        .split("/")
        .pop()
        .replace(".vue", "")

    app.component(componentName, module.default)
})


app.mount("#app")

function numberFormat(value, decimals = 2, decPoint = '.', thousandsSep = ',') {
    if (value === null || value === undefined) return '';

    const parts = Number(value)
        .toFixed(decimals)
        .split('.');

    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);

    return parts.join(decPoint);
}
