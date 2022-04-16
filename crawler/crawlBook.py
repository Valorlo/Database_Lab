from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager
from bs4 import BeautifulSoup
import time
import mysql.connector
from mysql.connector import Error

bookInfos = []

def processingData(wanted, cate, imgurl):
    info = {}
    for w in wanted:
        s = w.text.split(' ', 1)
        if len(s)>1:
            if s[0] == "國際標準書號":
                s[1] = s[1].split(" ")[0]
            info[s[0]] = s[1]
    info['category'] = cate
    info['img'] = imgurl
    if not info.__contains__("國際標準書號"):
        info['國際標準書號'] = ""
    if len(info) > 0:
        bookInfos.append(info)

options = Options()
options.add_argument("--disable-notifications")  # 取消所有的alert彈出視窗
 
browser = webdriver.Chrome(
    ChromeDriverManager().install(), chrome_options=options)
 
browser.get("https://dec.lib.nsysu.edu.tw/search~S2*cht/?searchtype=X&searcharg=%E8%B3%87%E6%96%99%E6%8E%A2%E5%8B%98&searchscope=4&sortdropdown=-&SORT=DZ&extended=0&SUBMIT=%E6%9F%A5%E8%A9%A2&searchlimits=&searchorigarg=X%7Bu8CC7%7D%7Bu6599%7D%7Bu63A2%7D%7Bu52D8%7D%26SORT%3DDZ&as_sfid=AAAAAAVSIP-HA5eClWlxP0Wt1QlqlQMBtrUWjgDEvj-puyr60XPsLPHr3royiFYGFklqu6szd9FrIMIh6mRkxhPR_nm_YB66Z9-Gj7EzVEf3npFtzvE1vtuVQSttHSiUXFQJu5o%3D&as_fid=1cf74ddb10e6de74f8918c7c53b6ba1e8f45e5ab")
 
contents = browser.find_elements_by_css_selector("span.briefcitTitle a")
for i in range(len(contents)):
    time.sleep(1)
    contents = browser.find_elements_by_css_selector("span.briefcitTitle a")
    cs = contents[i]
    cs.click()
    time.sleep(0.5)
    wanted = browser.find_elements_by_css_selector(".bibInfoEntry tr")
    img = browser.find_element_by_css_selector("#coverImage img").get_attribute("src")
    processingData(wanted, "學位論文", img)
    browser.back()

# print(bookInfos)
try:
    # 連接 MySQL/MariaDB 資料庫
    connection = mysql.connector.connect(
        host='localhost',          # 主機名稱
        database='library_system', # 資料庫名稱
        user='root',        # 帳號
        password='root')  # 密碼

    if connection.is_connected():

        # 顯示資料庫版本
        db_Info = connection.get_server_info()
        print("資料庫版本：", db_Info)

        # 顯示目前使用的資料庫
        cursor = connection.cursor()
        idx = 25
        for i in range(len(bookInfos)):
            # if i == 10:
            #     continue
            cursor.execute("INSERT INTO books(bkid, ISBN, publisher, author, bookname, category, status, img) VALUES(%s, %s, %s, %s, %s, %s, %s, %s);"
            ,((idx+i), bookInfos[i]["國際標準書號"], bookInfos[i]["出版項"], bookInfos[i]["主要作者"], bookInfos[i]["書/刊名"], bookInfos[i]["category"], 0, bookInfos[i]["img"])
            )
            connection.commit()

except Error as e:
    print("資料庫連接失敗：", e)

finally:
    if (connection.is_connected()):
        cursor.close()
        connection.close()
        print("資料庫連線已關閉")