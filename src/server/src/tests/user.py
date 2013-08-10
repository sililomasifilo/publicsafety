#!/usr/bin/python

import unittest
import requests
import json


class ClientTest(unittest.TestCase):
    def setUp(self):
        self.data = {
            'mobile_number': '1111222211',
            'email_id': 'a@d.com',
            'password': 'a@d.com',
            'name': 'a',
            'deviceToken': '1231231231',
            'latitude': '123321.1231',
            'longitude': '232342.2342',
        }
        self.BASE_URL = 'http://localhost/publicsafety/laravel/public/index.php/api/v1/user'
        self.auth = ('a', 'a@d.com')
        self.key = ''

    def test_user_post(self):
        data = requests.post(self.BASE_URL, data=self.data)
        with open('tests/user/userpost.html', 'w') as f:
            f.write(data.text.encode('utf-8'))
        self.key = str(json.loads(data.text)['key'])
        print self.key
        self.assertTrue(data.status_code == 200)

    def test_user_get(self):
        data = requests.get(self.BASE_URL, data=self.data, auth=self.auth)
        with open('tests/user/userget.html', 'w+') as f:
            f.write(data.text.encode('utf-8'))

        self.assertTrue(data.status_code == 405)
        self.assertFalse(data)

    def test_user_put(self):
        print self.BASE_URL + '/' + self.key
        data = requests.put(self.BASE_URL + '/' + str(self.key),
                            data={'mobile_number': 1231231},
                            auth=self.auth)
        with open('tests/user/userput.html', 'w') as f:
            f.write(data.text.encode('utf-8'))

        self.assertTrue(data.status_code == 200)

    '''def test_user_delete(self):
        data = requests.delete(self.BASE_URL + '/' + self.key,
                               data=self.data,
                               auth=self.auth)
        with open('tests/user/userdelete.html', 'w') as f:
            f.write(data.text.encode('utf-8'))
        self.assertTrue(data.status_code == 200)'''
