import pandas_datareader.data as web
import pandas as pd
import matplotlib.pyplot as plt
import numpy as np
from scipy.optimize import minimize

def get_risk(prices):
    return (prices / prices.shift(1) - 1).dropna().std().values
start='2015-11-25'
end='2016-09-30'

def get_return(prices):
    return ((prices / prices.shift(1) - 1).dropna().mean() * np.sqrt(250)).values
symbols = ['TCS', 'NFLX','GOOGL','PYPL']
prices = pd.DataFrame(index=pd.date_range(start, end))
for symbol in symbols:
    portfolio = web.DataReader(name=symbol, data_source='quandl', start=start, end=end)
    close = portfolio[['AdjClose']]
    close = close.rename(columns={'AdjClose': symbol})
    prices = prices.join(close)
    portfolio.to_csv("NSE\{}.csv".format(symbol))
prices = prices.dropna()
risk_v = get_risk(prices)
return_v = get_return(prices)
fig, ax = plt.subplots()
ax.scatter(x=risk_v, y=return_v, alpha=0.5)
ax.set(title='Return and Risk', xlabel='Risk', ylabel='Return')
min=risk_v[0]
index=0
for i, symbol in enumerate(symbols):
    if risk_v[i]<min:
        min=risk_v[i]
        index=i
        s=symbol
    ax.annotate(symbol, (risk_v[i], return_v[i]))
plt.savefig('NSE\onee.jpg')

f = open("predict_input.txt", "a")
f.write("NSE/%s\n"%(s))

def random_weights(n):
    weights = np.random.rand(n)
    return weights / sum(weights)
def get_portfolio_risk(weights, normalized_prices):
    portfolio_val = (normalized_prices * weights).sum(axis=1)
    portfolio = pd.DataFrame(index=normalized_prices.index, data={'portfolio': portfolio_val})
    return (portfolio / portfolio.shift(1) - 1).dropna().std().values[0]
def get_portfolio_return(weights, normalized_prices):
    portfolio_val = (normalized_prices * weights).sum(axis=1)
    portfolio = pd.DataFrame(index=normalized_prices.index, data={'portfolio': portfolio_val})
    ret = get_return(portfolio)
    return ret[0]
risk_all = np.array([])
return_all = np.array([])
# for demo purpose, plot 3000 random portoflio
np.random.seed(0)
normalized_prices = prices / prices.ix[0, :]
for _ in range(0, 3000):
    weights = random_weights(len(symbols))
    portfolio_val = (normalized_prices * weights).sum(axis=1)
    portfolio = pd.DataFrame(index=prices.index, data={'portfolio': portfolio_val})
    risk = get_risk(portfolio)
    ret = get_return(portfolio)
    risk_all = np.append(risk_all, risk)
    return_all = np.append(return_all, ret)
    p = get_portfolio_risk(weights=weights, normalized_prices=normalized_prices)
fig, ax = plt.subplots()
ax.scatter(x=risk_all, y=return_all, alpha=0.5)
ax.set(title='Return and Risk', xlabel='Risk', ylabel='Return')
for i, symbol in enumerate(symbols):
    ax.annotate(symbol, (risk_v[i], return_v[i]))
ax.scatter(x=risk_v, y=return_v, alpha=0.5, color='red')
ax.set(title='Return and Risk', xlabel='Risk', ylabel='Return')
ax.grid()
plt.savefig('NSE\one.jpg')
print('Portfolio Optimization Ended...')