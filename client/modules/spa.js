const path = require('path')
const fs = require('fs-extra')

/**
 * Copy dist files to public/ in spa mode.
 */
module.exports = function () {
  if (this.options.dev || this.options.mode !== 'spa') {
    return
  }

  const publicDir = path.resolve('./public' + this.options.build.publicPath)

  this.nuxt.hook('generate:done', async () => {
    const { html } = await this.nuxt.renderer.renderRoute('/', { url: '/' })

    fs.removeSync(publicDir)

    fs.copySync('./dist' + this.options.build.publicPath, publicDir)
    // fs.copy('./dist/200.html', publicDir + '/index.html')
    fs.writeFileSync(publicDir + '/index.html', html)

    try {
      // fs.removeSync(path.resolve('./dist'))
    } catch (e) {}
  })
}
