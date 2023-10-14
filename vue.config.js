const webpack = require('webpack');

module.exports = {
  pages: {
    index: {
      // entry for the page
      entry: 'src/main.ts',
      // the source template
      template: process.env.NODE_ENV === "production" ? 'src/index.html' : 'src/index_dev.html',
    },
  },

  configureWebpack: {
    plugins: [
      new webpack.DefinePlugin({
        'process.env.is_served': JSON.stringify(process.argv.includes('serve')), // true if run with 'yarn serve'
      })
    ]
  },

  // disable hashes in filenames
  filenameHashing: false,
}