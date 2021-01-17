module.exports = {
    devServer: {
        disableHostCheck: true
    },
    css: {
        loaderOptions: {
            sass: {
                additionalData: `@import "@/styles/util/_variables.scss";`
            }
        }
    }
};