// vue.config.js
const path = require('path')

module.exports = {
  // copy php files
  chainWebpack: config => {
    config.plugin('copy')
      .tap(args => {
        args[0].push({
          from: path.resolve(__dirname, 'php'),
          to: path.resolve(__dirname, 'dist'),
          toType: 'dir',
        })
        return args
      })
  },

  // disable hashes in filenames
  filenameHashing: false,
}