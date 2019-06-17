/**
 * Get cookie from request.
 *
 * @param  {Object} req
 * @param  {String} key
 * @return {String|undefined}
 */
export function cookieFromRequest (req, key) {
  if (!req.headers.cookie) {
    return
  }

  const cookie = req.headers.cookie.split(';').find(
    c => c.trim().startsWith(`${key}=`)
  )

  if (cookie) {
    return cookie.split('=')[1]
  }
}

/**
 * https://router.vuejs.org/en/advanced/scroll-behavior.html
 */
export function scrollBehavior (to, from, savedPosition) {
  if (savedPosition) {
    return savedPosition
  }

  let position = {}

  if (to.matched.length < 2) {
    position = { x: 0, y: 0 }
  } else if (to.matched.some(r => r.components.default.options.scrollToTop)) {
    position = { x: 0, y: 0 }
  } if (to.hash) {
    position = { selector: to.hash }
  }

  return position
}
