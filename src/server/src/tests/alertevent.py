#!/usr/bin/python

import unittest
import requests


class AlertEventTest(unittest.TestCase):
    def setUp(self):
        self.data = {}
        self.BASE_URL = 'localhost/publicsafety/public/index.php/alertevent'
        self.auth = {}

    def test_user_post(self):
        data = requests.post(self.BASE_URL, data=self.data)
        self.assertTrue(data)
        self.assertFalse(data)

    def test_user_get(self):
        data = requests.get(self.BASE_URL, data=self.data, auth=self.auth)
        self.assertTrue(data)
        self.assertFalse(data)

    def test_user_put(self):
        data = requests.put(self.BASE_URL, data=self.data, auth=self.auth)
        self.assertTrue(data)
        self.assertFalse(data)

    def test_user_delete(self):
        data = requests.delete(self.BASE_URL, data=self.data, auth=self.auth)
        self.assertTrue(data)
        self.assertFalse(data)
