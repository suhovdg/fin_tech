#Actions Calculator#

###requirements###
- php >= 5.5
- laravel >= 4.1

###data###
data in: POST request

 - terminal_id
 - auth_sign
 - event_sid
 - data


###Queue###
- calculated data http response(ff-actions-calc)
- calculated data to queue(ff-actions-calc-result)
- listening ff-actions-calc-result and sending data to foreign queue

###PostMan requests exported###
{"id":"4373a8da-8368-d17c-e89f-77a7e823cb9f","name":"homestead","timestamp":1404841512512,"requests":[{"collectionId":"4373a8da-8368-d17c-e89f-77a7e823cb9f","id":"5ae681df-27d7-ddad-04a8-99772863ed4d","name":"actions-calc_12.1 request","description":"data as json","url":"http://truetamtam.fintech-fab.ru:8000/actions-calc/getRequest","method":"POST","headers":"","data":[{"key":"event_sid","value":"under_rain","type":"text"},{"key":"terminal_id","value":"1","type":"text"},{"key":"auth_sign","value":"aa80b2eff808a4aeecb2c3b7cc00a0acf6d66a36","type":"text"},{"key":"data","value":"{\"time\":15.05, \"all_wet\":true}","type":"text"}],"dataMode":"params","timestamp":0,"responses":[],"version":2},{"collectionId":"4373a8da-8368-d17c-e89f-77a7e823cb9f","id":"5f10bb2c-3a2d-ba3d-8c55-f322b502678c","name":"eupathy actions-calc request","description":"","url":"http://truetamtam.fintech-fab.ru:8000/actions-calc/getRequest","method":"POST","headers":"","data":[{"key":"term","value":"1","type":"text"},{"key":"event","value":"im_hungry","type":"text"},{"key":"sign","value":"960aaa4661b6aabbaa0321aa16501327","type":"text"},{"key":"data","value":"{\"time\":15.05, \"some\": 2}","type":"text"}],"dataMode":"params","timestamp":0,"responses":[],"version":2}]}