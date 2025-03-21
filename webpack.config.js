const path = require('path');

module.exports = {
  entry: './public/js/websocket.js',
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'public/js'),
  },
};