module.exports = {
  pages: {
    index: {
      // entry for the page
      entry: 'src/main.ts',
      // the source template
      template: process.env.NODE_ENV === "production" ? 'src/index.html' : 'src/index_dev.html',
    },
  },

  // disable hashes in filenames
  filenameHashing: false,
}