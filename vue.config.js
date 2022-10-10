module.exports = {
  pages: {
    index: {
      // entry for the page
      entry: 'src/main.ts',
      // the source template
      template: 'src/index.html',
    },
  },

  // disable hashes in filenames
  filenameHashing: false,
}