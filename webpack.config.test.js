/* eslint-disable */
const path = require("path")

module.exports = {
  mode: 'development',
  entry: {
    NiconicoCustomMylistViewModelTests: './src/tests/NiconicoCustomMylistViewModelTests.ts'
  },
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
