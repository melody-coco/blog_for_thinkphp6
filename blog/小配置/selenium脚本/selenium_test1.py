from selenium import webdriver
#豆瓣的测试selenuim操作


x = webdriver.Chrome()

# url = "http://www.luolidao.com/"
url = "http://movie.douban.com/"

x.get(url)
x.find_element_by_name("search_text").send_keys("鸡巴")
x.find_element_by_id("inp-query").send_keys("毛线")

class_name = x.find_element_by_class_name("item").text
print("class_name定位内容如下"+class_name)
tag_name = x.find_element_by_tag_name("div").text
print("tag_name定位内容如下"+tag_name)

link_text = x.find_element_by_link_text("搜索电影、电视剧、综艺、影人").text
partial_text = x.find_element_by_partial_link_text("部正在热映").text

print("link_text定位的内容如下"+link_text)
print("partial_text定位的内容如下"+partial_text)

css_select = x.find_element_by_css_selector("#db-nav-movie > div.nav-wrap > div > div.nav-logo > a").text
print("css_select定位的内容如下"+css_select)