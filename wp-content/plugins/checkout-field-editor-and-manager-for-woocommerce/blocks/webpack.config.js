const path = require('path');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
    ...defaultConfig,
    context: path.resolve(__dirname),
    entry: {
        'admin/admin-index': './admin/index.js',
        'checkout/checkout-index': './checkout/index.js',
    },
    output: {
        path: path.resolve(__dirname, '../block-assets'),
        filename: '[name].js',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env', '@babel/preset-react'],
                    },
                },
            },
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            modules: {
                                auto: /\.module\.scss$/,
                                localIdentName: '[name]__[local]--[hash:base64:5]',
                            },
                        },
                    },
                    'sass-loader',
                ],
            },
            {
                 test: /\.(svg|png)$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 8192, // Inline files smaller than 8kb
                            name: 'images/[name].[hash].[ext]', // Output path for larger files
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        ...defaultConfig.plugins,
        new MiniCssExtractPlugin({
            filename: '[name].css',
        }),
    ],
};