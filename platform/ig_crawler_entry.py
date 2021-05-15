# -*- coding: utf-8 -*-
"""
Created on Mon May 10 10:24:46 2021

@author: Asus
及時爬蟲測試
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
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
options.add_experimental_option('excludeSwitches', ['enable-logging'])
chrome = webdriver.Chrome('../chromedriver.exe', chrome_options=options)

"https://www.instagram.com/"


def use_ig():
    chrome.get("https://www.instagram.com/")
    time.sleep(15)
    email = chrome.find_element_by_name("username")
    password = chrome.find_element_by_name("password")
    email.send_keys('travel_fun_test')
    password.send_keys('biging888')
    password.submit()
# 讓使用者登入追蹤他的好友
    time.sleep(3)

    soup = BeautifulSoup(chrome.page_source, 'html.parser')
    # chrome.quit()
# chrome.quit()  #關閉瀏覽器


def selenium_ig(url):
    chrome.get(url)
    time.sleep(5)
    soup = BeautifulSoup(chrome.page_source, 'html.parser')
    # chrome.quit()
    r = str(soup).split(';">')[1].split('</pre>')[0]
    # 到此處r為原本request到的內容
    return r


def get_post_time(data):  # 取得文章日期
    # 需要傳入文章date
    # 1091120 update
    post_time = data['graphql']['shortcode_media']['taken_at_timestamp']
    return post_time
    # 取得拍攝仁和時間資訊


def parseig_location(tag, post_num):
    arr = []
    end_cursor = ''  # empty for the 1st page
    tag = tag  # tag
    page_count = 1  # desired number of pages
    for i in range(0, page_count):
        url = "https://www.instagram.com/explore/tags/{0}/?__a=1&max_id={1}".format(
            tag, end_cursor)
        r = selenium_ig(url)
        try:
            data = json.loads(r)
        except:
            r = None
            data = []
        if data != []:
            # value for the next page
            end_cursor = data['graphql']['hashtag']['edge_hashtag_to_media']['page_info']['end_cursor']
            # list with posts
            edges = data['graphql']['hashtag']['edge_hashtag_to_media']['edges']
        else:
            continue
        for item in edges:
            arr.append(item['node'])
        time.sleep(5)
    locations = []
    locate = []
    x = 0

    # 記爬文數
    for item in arr:
        shortcode = item['shortcode']
        url = "https://www.instagram.com/p/{0}/?__a=1".format(shortcode)
        time.sleep(5)
        r = selenium_ig(url)
        data = json.loads(r)
        try:
            # get location for a post
            location = data['graphql']['shortcode_media']['location']['name']
        except:
            location = ''  # if location is NULL
        stamptime = get_post_time(data)
        locations.append(
            {'shortcode': shortcode, 'location': location, 'stamptime': stamptime})
        if len(location) > 0:
            print(location)
            print(stamptime)
            locate.append(location)
            x += 1
            if x == post_num:
                break

    '''now = datetime.datetime.now()
    locate_name = now.strftime(tag + "  %Y_%m_%d_%H_%M_%S" + ".txt")
    dest_dir = "D:\git\ig/"
    file_name = dest_dir + locate_name
    with open(file_name, 'w',encoding = 'utf-16') as outfile:
        outfile.write(str(locations))# save to json
    update_data(tag,file_name)'''
    file = str(locations)
    update_data(tag, file)


def update_data(tag, file):
    item = file.split("}, {'")
    for i in item:
        location = i.split("'location': ")[1].split(", 'stamptime'")[0]
        if location != "''" and location != "''}]":
            location = location[1:-1]
            shortcode = i.split("shortcode': ")[1].split(", 'location':")[0]
            shortcode = shortcode[1:-1]
            timestamp = i.split("'stamptime':")[1].lstrip()
            print("shortcode:{shortcode},location:{location},timestamp:{timestamp},tag_ara:{tag}".format(
                shortcode=shortcode, location=location, timestamp=timestamp, tag=tag))
            print(judge_shortcode(shortcode))
            if judge_shortcode(shortcode) == "Repeated_shortcode":
                print("貼文重複")
                continue
            else:
                link_database(location, shortcode, timestamp, tag)
    read_database()


def judge_shortcode(given_shortcode):
    try:
        # 連接 MySQL/MariaDB 資料庫
        connection = mysql.connector.connect(
            port=3306,
            host='127.0.0.1',          # 主機名稱
            database='travelfun',  # 資料庫名稱
            user='root',        # 帳號
            password='TravelFun@4',
            auth_plugin='mysql_native_password')  # 密碼

        x = "not_repeated"
        if connection.is_connected():
            sql = "SELECT * FROM `sight`"
            cursor = connection.cursor()
            cursor.execute(sql)
            for (view_id, view_name, shortcode, timestamp, tag_area, source, status) in cursor:
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


def link_database(view, code, time, tag):
    try:
        # 連接 MySQL/MariaDB 資料庫
        connection = mysql.connector.connect(
            port=3306,
            host='127.0.0.1',          # 主機名稱
            database='travelfun',  # 資料庫名稱
            user='root',        # 帳號
            password='TravelFun@4',
            auth_plugin='mysql_native_password')  # 密碼

        if connection.is_connected():

            # 顯示資料庫版本
            db_Info = connection.get_server_info()
            print("資料庫版本：", db_Info)

            view_ids = [0]
            sql = "SELECT * FROM `sight`"
            cursor = connection.cursor()
            cursor.execute(sql)
            for (view_id, view_name, shortcode, timestamp, tag_area, source, status) in cursor:
                view_ids.append(view_id)
            view_id = max(view_ids) + 1
            view_name = view
            shortcode = code
            timestamp = time
            tag_area = tag
            # INSERT INTO `location` (`view_id`, `view_name`, `shortcode`) VALUES ('2', 'The Misanthrope Society 厭世會社', 'CIK4d_QHHpc');
            sql = "INSERT INTO `sight` (`view_id`, `view_name`, `shortcode`,`timestamp`, `tag_area`) VALUES (" + "'" + str(
                view_id) + "'" + "," + "'" + view_name + "'" + "," + "'" + shortcode + "'" + "," + "'" + timestamp + "'" + "," + "'" + tag_area + "'" + ");"
            cursor = connection.cursor()
            cursor.execute(sql)
            connection.commit()
            sql = "SELECT * FROM `sight`"
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
            host='127.0.0.1',          # 主機名稱
            database='travelfun',  # 資料庫名稱
            user='root',        # 帳號
            password='TravelFun@4',
            auth_plugin='mysql_native_password')  # 密碼

        if connection.is_connected():
            sql = "SELECT * FROM `sight`"
            cursor = connection.cursor()
            cursor.execute(sql)
            for (view_id, view_name, shortcode, timestamp, tag_area, source, status) in cursor:
                print('id:{0} , name:{1} ,shortcode:{2},area:{3}'.format(
                    view_id, view_name, shortcode, tag_area))

    except Error as e:
        print("資料庫連接失敗：", e)

    finally:
        if (connection.is_connected()):
            cursor.close()
            connection.close()
            print("資料庫連線已關閉")


if __name__ == "__main__":
    tag = input("輸入爬取地點:")
    post_num = input("景點數量:")
    post_num = int(post_num)
    use_ig()
    parseig_location(tag, post_num)

chrome.quit()


# read_database()
