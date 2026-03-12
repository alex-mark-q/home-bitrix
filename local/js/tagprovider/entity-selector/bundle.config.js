module.exports = {
	input: 'src/index.js',
	output: 'dist/index.bundle.js',
	concat: {
		css: ['src/style.css']
	},
	namespace: 'BX.TagSelector.EntitySelector',
	adjustConfigPhp: false
};
