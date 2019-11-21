<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Rates</div>

                    <div class="card-body">
                        <div v-for="rate in rates">
                            {{rate.currency.code}}: {{rate.rate}}
                        </div>
                        <div>
                            <button class="btn btn-info" v-on:click="prev" :disabled="page == 1">Prev</button>
                            <button class="btn btn-info" v-on:click="next" :disabled="page == lastPage">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                rates: [],
                page: 1,
                lastPage: null
            }
        },
        mounted() {
            this.fetch();
        },
        methods: {
            fetch : function(page = 1) {
                axios.get('/rates/' + page)
                    .then((response) => {
                        this.rates = response.data.data;
                        this.lastPage = response.data.last_page;
                    })
            },
            next : function() {
                this.fetch(++this.page);
            },
            prev : function() {
                this.fetch(--this.page);
            }
        }
    }
</script>
