/* eslint-disable */
const path = require("path")

module.exports = {
  mode: 'development',
  entry: entry(),
  output: {
    path: path.resolve(__dirname, "src/tests"),
    filename: '[name].js'
  },
  module: {
    rules: [
      {
        test: /\.(ts|tsx)$/i,
        exclude: ["/node_modules/"],
        use: {
          loader: "ts-loader",
          options: {
            // Set Target
            configFile: path.resolve(__dirname, 'tsconfig.test.json')
          }
        }
      },
    ],
  },
  resolve: {
    extensions: [".js", ".ts"],
    alias: {
      "@": path.resolve(__dirname, "src"),
    },
  },
  target: 'node',
}

function entry() {
  /* eslint-disable */
  const fs = require('fs')

  var entries = {}

  const path = process.cwd()
  const apiTests = fs.readdirSync(`${path}/src/tests/apis`)
  const modelTests = fs.readdirSync(`${path}/src/tests/models`)
  const storeTests = fs.readdirSync(`${path}/src/tests/store`)
  const viewModelTests = fs.readdirSync(`${path}/src/tests/viewModels`)

  apiTests.forEach(file => {
    if (!String(file).includes('TestBase.ts')) {
      Object.assign(entries, { [file.substring(0, file.length - 3)]: `${path}/src/tests/apis/${file}` })
    }
  })

  modelTests.forEach(file => {
    if (!String(file).includes('TestBase.ts')) {
      Object.assign(entries, { [file.substring(0, file.length - 3)]: `${path}/src/tests/models/${file}` })
    }
  })

  storeTests.forEach(file => {
    if (!String(file).includes('TestBase.ts')) {
      Object.assign(entries, { [file.substring(0, file.length - 3)]: `${path}/src/tests/store/${file}` })
    }
  })

  viewModelTests.forEach(file => {
    if (!String(file).includes('TestBase.ts')) {
      Object.assign(entries, { [file.substring(0, file.length - 3)]: `${path}/src/tests/viewModels/${file}` })
    }
  })

  return entries
}
