export const login = [
  {
    key: 'login',
    type: 'input-with-field',
    required: true,
    templateOptions: {
      wrapper: {
        properties: {
          addons: false,
          label: 'Login'
        }
      }
    }
  },
  {
    key: 'password',
    type: 'input-with-field',
    required: true,
    templateOptions: {
      properties: {
        'password-reveal': true,
        type: 'password'
      },
      wrapper: {
        properties: {
          addons: false,
          label: 'Password'
        }
      }
    }
  }
]
