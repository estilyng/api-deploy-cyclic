module.exports = {
    "transpileDependencies": [
        "vuetify"
    ],

    devServer: {
        host: 'localhost'
  
    },

    publicPath: '/',

    pwa: {
        name: 'Sat-Saúde',
        themeColor: '#4DBA87',
        msTileColor: '#000000',
        appleMobileWebAppCapable: 'yes',
        appleMobileWebAppStatusBarStyle: 'black',

        // configure the workbox plugin
        // workboxPluginMode: 'InjectManifest',
        // workboxOptions: {
        //     // swSrc is required in InjectManifest mode.
        //     swSrc: 'dev/sw.js',
        //     // ...other Workbox options...
        // }
    },

    pluginOptions: {
      quasar: {
        importStrategy: 'kebab',
        rtlSupport: true
      }
    },

    transpileDependencies: [
      'vuetify',
      'quasar'
    ]
}
