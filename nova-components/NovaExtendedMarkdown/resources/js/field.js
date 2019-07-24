Nova.booting((Vue, router, store) => {
    Vue.component('index-extended-markdown', require('./components/IndexField'))
    Vue.component('detail-extended-markdown', require('./components/DetailField'))
    Vue.component('form-extended-markdown', require('./components/FormField'))
})
