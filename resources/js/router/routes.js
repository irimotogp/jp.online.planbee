function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'index', component: page('introducer.vue') },
  { path: '/agency/:uuid', name: 'agency', component: page('agency.vue') },
  { path: '/customer/:uuid', name: 'customer', component: page('customer.vue') },
  { path: '/expired', name: 'expired', component: page('expired.vue') },
  { path: '/thanks_i', name: 'thanks_i', component: page('thanks_i.vue') },
  { path: '/thanks_o', name: 'thanks_o', component: page('thanks_o.vue') },
  // { path: '/login', name: 'login', component: page('auth/login.vue') },
  // { path: '/register', name: 'register', component: page('auth/register.vue') },
  // { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  // { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  // { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  // { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  // { path: '/home', name: 'home', component: page('home.vue') },
  // {
  //   path: '/settings',
  //   component: page('settings/index.vue'),
  //   children: [
  //     { path: '', redirect: { name: 'settings.profile' } },
  //     { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
  //     { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
  //   ]
  // },

  { path: '*', component: page('errors/404.vue') }
]
