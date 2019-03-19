#!/usr/bin/python
import pandas_datareader.data as web
import pandas as pd
import matplotlib.pyplot as plt
import numpy as np
from scipy.optimize import minimize
import os
os.remove("predict_input.txt")

f = open("loginData.txt", "r")
f1 = open("predict_input.txt", "a")
investment=f.readline().rstrip()
sect=f.readline().rstrip()
print(sect)
while sect:

	if sect=="Finance":
		symbols = ['HDFC', 'BAJFINANCE','BAJAJFINSV']
	if sect=="Pharma":
		symbols = ['LUPIN', 'DRREDDY','SUNPHARMA']
	if sect=="IT":
		symbols = ['TCS', 'ITC','HCLTECH']
	if sect=="Banking":
		symbols = ['HDFCBANK', 'AXISBANK','KOTAKBANK']
	if sect=="Energy":
		symbols = ['RELIANCE', 'ONGC','BPCL']


	def get_risk(prices):
		return (prices / prices.shift(1) - 1).dropna().std().values
	start='2015-11-25'
	end='2016-09-30'

	def get_return(prices):
		return ((prices / prices.shift(1) - 1).dropna().mean() * np.sqrt(250)).values


	prices = pd.DataFrame(index=pd.date_range(start, end))
	for symbol in symbols:
		portfolio = web.DataReader(name=symbol, data_source='quandl', start=start, end=end)
		close = portfolio[['Close']]
		close = close.rename(columns={'Close': symbol})
		prices = prices.join(close)
		portfolio.to_csv("NSE\{}.csv".format(symbol))
	prices = prices.dropna()
	risk_v = get_risk(prices)
	return_v = get_return(prices)
	fig, ax = plt.subplots()
	ax.scatter(x=risk_v, y=return_v, alpha=0.5)
	ax.set(title='Return and Risk', xlabel='Risk', ylabel='Return')
	min=1000
	index=0

	for i, symbol in enumerate(symbols):
		if risk_v[i]<min:
			min=risk_v[i]
			index=i
			s=symbol
#		print(symbol, (risk_v[i], return_v[i]))
		ax.annotate(symbol, (risk_v[i], return_v[i]))
	plt.savefig("NSE/"+sect+".jpg")

	f1.write("NSE/%s\n"%(s))
	
	sect=f.readline().rstrip()
	print(sect)

f.close()
f1.close()
print('Portfolio Optimization Ended...')

import predic
os.system('python predic.py')
print("Prediction called")