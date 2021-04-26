# -*- coding: utf-8 -*-
"""
Created on Mon Apr 19 08:02:01 2021

@author: Asus
改掉儲存本機
放上heroku
加入debug
port=3306,
            host='us-cdbr-east-02.cleardb.com',          # 主機名稱
            database='heroku_3b556a8a0461946', # 資料庫名稱
            user='b0ac2d8faa8cbc',        # 帳號
            password='c9aadd1b'
"""

from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import time
import datetime
from bs4 import BeautifulSoup
import json
import mysql.connector
from mysql.connector import Error
import os

global options
global chrome
options = Options()
options.add_argument("--disable-notifications")
chrome = webdriver.Chrome('D:\git/chromedriver', chrome_options=options)

"https://www.instagram.com/"


    
def use_ig():
    chrome.get("https://www.instagram.com/")
    time.sleep(15)
    email = chrome.find_element_by_name("username")
    password = chrome.find_element_by_name("password")
    email.send_keys('travel_fun_test')
    password.send_keys('biging888')
    password.submit()
#讓使用者登入追蹤他的好友
    time.sleep(3)

    soup = BeautifulSoup(chrome.page_source, 'html.parser')
    #chrome.quit()
#chrome.quit()  #關閉瀏覽器

def selenium_ig(url):
    chrome.get(url)
    time.sleep(5)
    soup = BeautifulSoup(chrome.page_source, 'html.parser')
    #chrome.quit()
    r = str(soup).split(';">')[1].split('</pre>')[0]
    #到此處r為原本request到的內容
    return r

def get_post_time(data):        #取得文章日期
    #需要傳入文章date
    #1091120 update
    post_time = data['graphql']['shortcode_media']['taken_at_timestamp']
    return post_time
    #取得拍攝仁和時間資訊    

def parseig_location():
    arr = []
    end_cursor = '' # empty for the 1st page
    tag = 'Taoyuan' # tag
    page_count = 1 # desired number of pages
    for i in range(0, page_count):
        url = "https://www.instagram.com/explore/tags/{0}/?__a=1&max_id={1}".format(tag, end_cursor)
        r = selenium_ig(url)
        try:
            data = json.loads(r)
        except:
            r = None
        if data != [ ]:
            end_cursor = data['graphql']['hashtag']['edge_hashtag_to_media']['page_info']['end_cursor'] # value for the next page
            edges = data['graphql']['hashtag']['edge_hashtag_to_media']['edges'] # list with posts
        else:
            continue
        for item in edges:
            arr.append(item['node'])
        time.sleep(5)
    locations = []
    locate = []
    for item in arr:
        shortcode = item['shortcode']
        url = "https://www.instagram.com/p/{0}/?__a=1".format(shortcode)
        time.sleep(5)
        r = selenium_ig(url)
        try:
            data = json.loads(r)
            location = data['graphql']['shortcode_media']['location']['name'] # get location for a post
        except:
            print("爬蟲受到中止，從新執行")
            start_crawel()
            # if location is NULL
        stamptime = get_post_time(data)
        locations.append({'shortcode': shortcode, 'location': location , 'stamptime':stamptime })
        if len(location) > 0:
            print(location)
            print(stamptime)
            locate.append(location)
            
    '''now = datetime.datetime.now() 
    locate_name = now.strftime(tag + "  %Y_%m_%d_%H_%M_%S" + ".txt")
    dest_dir = "D:\git\ig/"
    file_name = dest_dir + locate_name
    with open(file_name, 'w',encoding = 'utf-16') as outfile:
        outfile.write(str(locations))# save to json
    update_data(tag,file_name)'''
    file = str(locations)
    update_data(tag,file)

def update_data(tag,file):
    item = file.split("}, {'")
    for i in item:
        location = i.split("'location': ")[1].split(", 'stamptime'")[0]
        if location != "''" and location != "''}]":
            location = location[1:-1]
            shortcode = i.split("shortcode': ")[1].split(", 'location':")[0]
            shortcode = shortcode[1:-1]
            timestamp = i.split("'stamptime':")[1].lstrip()
            print("shortcode:{shortcode},location:{location},timestamp:{timestamp},tag_ara:{tag}".format(shortcode = shortcode,location = location,timestamp = timestamp,tag = tag))
            print(judge_shortcode(shortcode))
            if judge_shortcode(shortcode) == "Repeated_shortcode" :
                print("貼文重複")
                continue
            else:
                link_database(location,shortcode,timestamp,tag)
    read_database()

def judge_shortcode(given_shortcode):
    try:
    # 連接 MySQL/MariaDB 資料庫
        connection = mysql.connector.connect(
            port=3306,
            host='us-cdbr-east-02.cleardb.com',          # 主機名稱
            database='heroku_3b556a8a0461946', # 資料庫名稱
            user='b0ac2d8faa8cbc',        # 帳號
            password='c9aadd1b')  # 密碼
        
        x = "not_repeated"
        if connection.is_connected():
            sql = "SELECT * FROM `ig_sights`"
            cursor = connection.cursor()
            cursor.execute(sql)
            for (view_id,view_name,shortcode,timestamp,tag_area) in cursor:
                if given_shortcode == shortcode:
                    x = "Repeated_shortcode"
                    break
                else:
                    x = "ok"
            return x

    except Error as e:
        print("資料庫連接失敗：", e)

    finally:
        if (connection.is_connected()):
            cursor.close()
            connection.close()
            print("資料庫連線已關閉")

def link_database(view,code,time,tag): 
    try:
    # 連接 MySQL/MariaDB 資料庫
        connection = mysql.connector.connect(
            port=3306,
            host='us-cdbr-east-02.cleardb.com',          # 主機名稱
            database='heroku_3b556a8a0461946', # 資料庫名稱
            user='b0ac2d8faa8cbc',        # 帳號
            password='c9aadd1b')  # 密碼

        if connection.is_connected():

        # 顯示資料庫版本
            db_Info = connection.get_server_info()
            print("資料庫版本：", db_Info)


            view_ids = [0]
            sql = "SELECT * FROM `ig_sights`"
            cursor = connection.cursor()
            cursor.execute(sql)
            for (view_id,view_name,shortcode,timestamp,tag_area) in cursor:
                view_ids.append(view_id)
            view_id = max(view_ids) + 1
            view_name = view
            shortcode = code
            timestamp = time
            tag_area = tag
            #INSERT INTO `location` (`view_id`, `view_name`, `shortcode`) VALUES ('2', 'The Misanthrope Society 厭世會社', 'CIK4d_QHHpc');
            sql = "INSERT INTO `ig_sights` (`view_id`, `view_name`, `shortcode`,`timestamp`, `tag_area`) VALUES (" + "'" + str(view_id) + "'" + "," + "'" + view_name + "'" + "," + "'" + shortcode +"'"  +  "," + "'" + timestamp +"'" + "," + "'" + tag_area +"'" +  ");"
            cursor = connection.cursor()
            cursor.execute(sql)
            connection.commit()
            sql = "SELECT * FROM `ig_sights`"
            cursor = connection.cursor()
            cursor.execute(sql)

    except Error as e:
        print("資料庫連接失敗：", e)

    finally:
        if (connection.is_connected()):
            cursor.close()
            connection.close()
            print("資料庫連線已關閉")
            
def read_database():
    try:
    # 連接 MySQL/MariaDB 資料庫
        connection = mysql.connector.connect(
            port=3306,
            host='us-cdbr-east-02.cleardb.com',          # 主機名稱
            database='heroku_3b556a8a0461946', # 資料庫名稱
            user='b0ac2d8faa8cbc',        # 帳號
            password='c9aadd1b')  # 密碼
        
        if connection.is_connected():
            sql = "SELECT * FROM `ig_sights`"
            cursor = connection.cursor()
            cursor.execute(sql)
            for (view_id,view_name,shortcode,timestamp,tag_area) in cursor:
                print('id:{0} , name:{1} ,shortcode:{2},area:{3}'.format(view_id,view_name,shortcode,tag_area))

    except Error as e:
        print("資料庫連接失敗：", e)

    finally:
        if (connection.is_connected()):
            cursor.close()
            connection.close()
            print("資料庫連線已關閉")

def start_crawel():
    use_ig()
    parseig_location()
    chrome.quit()
    
##############################################################################
###fb
##############################################################################



def use_fb():
    chrome.get("https://www.facebook.com/")
    email = chrome.find_element_by_id("email")
    password = chrome.find_element_by_id("pass")
    email.send_keys('bigbird7887@gmail.com')
    password.send_keys('biging888')
    password.submit()
    time.sleep(5)
    chrome.get("https://www.facebook.com/hashtag/taipei")
#讓使用者登入追蹤他的好友
    time.sleep(1)
    for x in range(1, 20):
        chrome.execute_script("window.scrollTo(0,document.body.scrollHeight)")
        time.sleep(2)
        
    time.sleep(5)

    soup = BeautifulSoup(chrome.page_source, 'html.parser')
    time.sleep(5)
    #chrome.quit()
    #now = datetime.datetime.now() 
    #locate_name = now.strftime("selenium_test_fb" + "  %Y_%m_%d_%H_%M_%S" + ".txt")
    #dest_dir = "D:\git\ig/"
    #file_name = dest_dir + locate_name
    #with open(file_name, 'w',encoding = 'utf-16') as outfile:
    #    outfile.write(str(soup))# save to json
    #titles = soup.find_all(class_="nc684nl6")
    #<div class="nc684nl6"><span>
    text = str(soup)
    locate = text.split('class="oajrlxb2 g5ia77u1 qu0x051f esr5mh6w e9989ue4 r7d6kgcz rq0escxv nhd2j8a9 nc684nl6 p7hjln8o kvgmc6g5 cxmmr5t8 oygrvhab hcukyx3x jb3vyjys rz4wbd8a qt6c0cv9 a8nywdso i1ao9s8h esuyzwwr f1sip0of lzcic4wl oo9gr5id gpro0wi8 lrazzd5p"')
    locations = []
    times = []
    arr = [] #用來尋找含地點的貼文範圍
    i = 0
    for t in locate:
        if '──在 ' in t:
            arr.append(i)#這篇文含有地點加入list
        i = i + 1 #下一篇

    location = []
    for a in arr: #a為含有地點貼文試試list中第幾個
        if a+1 >= len(locate):
            break
        location.append(locate[a+1]) #將含有地點的全部貼文整理成新列表

    
    for text in location:
        if '<div class="nc684nl6"><span>' in text and '</span></div>' in text:
            locations.append(text.split('<div class="nc684nl6"><span>')[1].split('</span></div>')[0])
    
        
    for locate in locations:
        print(locate)
    for t in times:
        print(t)



use_fb()         
#start_crawel()