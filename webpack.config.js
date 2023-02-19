const CopyFilePlugin = require("copy-webpack-plugin");

const path = require("path");


const isProduction = process.env.NODE_ENV == "production"

const config = {
  entry: {
    // main: "./src/index.ts",
    app: "./resources/js/app.js",
  },
  output: {
    path: path.resolve(__dirname, "dist/js"),
    filename: '[name].js',
  },
  plugins: [
    // Add your plugins here
    // Learn more about plugins from https://webpack.js.org/configuration/plugins/
    new CopyFilePlugin({
      patterns: [
        {
          context: path.resolve(__dirname, "public"),
          from: path.resolve(__dirname, "public/**/*"),
          to: path.resolve(__dirname, "dist"),
        },
        {
          context: path.resolve(__dirname, "public"),
          from: path.resolve(__dirname, "public/**/.*"),
          to: path.resolve(__dirname, "dist"),
        }
      ]
    })
  ],
  module: {
    rules: [
      // {
      //   test: /\.(ts|tsx)$/i,
      //   loader: "ts-loader",
      //   exclude: ["/node_modules/"],
      // },
      // {
      //   test: /\.(eot|svg|ttf|woff|woff2|png|jpg|gif)$/i,
      //   type: "asset",
      // },

      // Add your rules for custom modules here
      // Learn more about loaders from https://webpack.js.org/loaders/
    ],
  },
  resolve: {
    // extensions: [".tsx", ".ts", ".jsx", ".js", "..."],
  },
}

module.exports = () => {
  if (isProduction) {
    config.mode = "production"
  } else {
    config.mode = "development"
  }
  return config
}
